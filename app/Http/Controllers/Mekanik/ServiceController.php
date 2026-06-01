<?php
// app/Http/Controllers/Mekanik/ServiceController.php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    /**
     * Menampilkan detail service
     */
    public function detail(Booking $booking)
    {
        $this->authorizeMekanik($booking);

        $booking->load(['customer.user', 'jenisService']);

        // Ambil sparepart yang sudah digunakan (jika ada)
        $usedSpareparts = DB::table('service_spareparts')
            ->where('service_id', $booking->id)
            ->join('spareparts', 'service_spareparts.sparepart_id', '=', 'spareparts.id')
            ->select('service_spareparts.*', 'spareparts.nama_sparepart', 'spareparts.satuan')
            ->get();

        $spareparts = Sparepart::where('is_active', true)
            ->orderBy('nama_sparepart')
            ->get();

        return view('pages.mekanik.services.detail', compact('booking', 'spareparts', 'usedSpareparts'));
    }

    /**
     * Memulai service (ubah status dari dijadwalkan menjadi diproses)
     */
    public function start(Booking $booking)
    {
        $this->authorizeMekanik($booking);

        if ($booking->status != 'dijadwalkan') {
            return redirect()->back()->with('error', 'Service tidak dapat dimulai.');
        }

        DB::beginTransaction();

        try {
            // Update status booking
            $booking->update(['status' => 'diproses']);

            // Cek apakah sudah ada service record
            $existingService = DB::table('services')->where('booking_id', $booking->id)->first();

            if (!$existingService) {
                // INSERT ke tabel services
                DB::table('services')->insert([
                    'booking_id' => $booking->id,
                    'hasil_pemeriksaan' => null,
                    'tindakan_service' => null,
                    'status_service' => 'in_progress',
                    'tanggal_mulai' => now(),
                    'tanggal_selesai' => null,
                    'catatan_mekanik' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('mekanik.services.detail', $booking)
                ->with('success', 'Service telah dimulai.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memulai service: ' . $e->getMessage());
        }
    }

    /**
     * Menyelesaikan service dengan input pemeriksaan, tindakan, dan sparepart
     */
    public function complete(Request $request, Booking $booking)
    {
        $this->authorizeMekanik($booking);

        // Cek apakah status booking adalah diproses
        if ($booking->status != 'diproses') {
            return redirect()->back()->with('error', 'Service tidak dapat diselesaikan. Status booking harus "Diproses".');
        }

        $request->validate([
            'hasil_pemeriksaan' => 'required|string|min:10',
            'tindakan_service' => 'required|string|min:10',
            'spareparts' => 'nullable|array',
            'spareparts.*.id' => 'exists:spareparts,id',
            'spareparts.*.quantity' => 'required|integer|min:1',
        ]);

        Log::info('Request Complete Service', [
            'booking_id' => $booking->id,
            'request' => $request->all()
        ]);

        DB::beginTransaction();

        try {
            // Update booking dengan hasil pemeriksaan dan tindakan
            $booking->update([
                'hasil_pemeriksaan' => $request->hasil_pemeriksaan,
                'tindakan_service' => $request->tindakan_service,
                'status' => 'menunggu_pembayaran',
            ]);

            // Cari service record berdasarkan booking_id
            $service = DB::table('services')->where('booking_id', $booking->id)->first();

            if (!$service) {
                throw new \Exception('Service record tidak ditemukan untuk booking ini.');
            }

            // Update service record
            DB::table('services')
                ->where('booking_id', $booking->id)
                ->update([
                    'hasil_pemeriksaan' => $request->hasil_pemeriksaan,
                    'tindakan_service' => $request->tindakan_service,
                    'status_service' => 'completed',
                    'tanggal_selesai' => now(),
                    'catatan_mekanik' => $request->catatan_mekanik ?? null,
                    'updated_at' => now(),
                ]);

            // Hapus sparepart lama jika ada (menggunakan service_id dari tabel services)
            DB::table('service_spareparts')->where('service_id', $service->id)->delete();

            $totalSparepart = 0;

            // Simpan sparepart yang digunakan
            if ($request->has('spareparts')) {
                foreach ($request->spareparts as $item) {
                    if (empty($item['id']) || empty($item['quantity'])) {
                        continue;
                    }

                    $sparepart = Sparepart::find($item['id']);

                    // Kurangi stok
                    if (!$sparepart->reduceStock($item['quantity'])) {
                        throw new \Exception("Stok {$sparepart->nama_sparepart} tidak mencukupi");
                    }

                    $subtotal = $sparepart->harga_jual * $item['quantity'];
                    $totalSparepart += $subtotal;

                    // Simpan ke service_spareparts menggunakan service_id dari tabel services
                    DB::table('service_spareparts')->insert([
                        'service_id' => $service->id,  // ← menggunakan service.id, bukan booking.id
                        'sparepart_id' => $item['id'],
                        'jumlah' => $item['quantity'],
                        'price' => $sparepart->harga_jual,
                        'subtotal' => $subtotal,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Update total pembayaran
            $totalBayar = $booking->jenisService->harga + $totalSparepart;
            $booking->update(['total_bayar' => $totalBayar]);

            DB::commit();

            return redirect()->route('mekanik.tasks.index')
                ->with('success', 'Service selesai. Menunggu pembayaran customer.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyelesaikan service: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan invoice/service report yang sudah selesai
     */
    public function invoice(Booking $booking)
    {
        $this->authorizeMekanik($booking);

        if ($booking->status != 'selesai' && $booking->status != 'menunggu_pembayaran') {
            abort(404, 'Service belum selesai');
        }

        $booking->load(['customer.user', 'jenisService']);

        $usedSpareparts = DB::table('service_spareparts')
            ->where('service_id', $booking->id)
            ->join('spareparts', 'service_spareparts.sparepart_id', '=', 'spareparts.id')
            ->select('service_spareparts.*', 'spareparts.nama_sparepart', 'spareparts.satuan')
            ->get();

        return view('pages.mekanik.services.invoice', compact('booking', 'usedSpareparts'));
    }

    /**
     * Authorisasi mekanik
     */
    protected function authorizeMekanik(Booking $booking)
    {
        $mekanik = Auth::user()->mekanik;

        if (!$mekanik || $booking->mekanik_id !== $mekanik->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
