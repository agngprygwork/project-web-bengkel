<?php
// app/Http/Controllers/Mekanik/TaskController.php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Menampilkan semua tugas mekanik
     */
    public function index(Request $request)
    {
        $mekanik = Auth::user()->mekanik;

        $query = Booking::where('mekanik_id', $mekanik->id)
            ->with(['customer.user', 'jenisService']);

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                    ->orWhereHas('customer.user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('pages.mekanik.tasks.index', compact('tasks'));
    }

    /**
     * Menampilkan tugas hari ini
     */
    public function today()
    {
        $mekanik = Auth::user()->mekanik;

        $tasks = Booking::where('mekanik_id', $mekanik->id)
            ->whereDate('tanggal_booking', today())
            ->with(['customer.user', 'jenisService'])
            ->orderBy('waktu_booking', 'asc')
            ->get();

        return view('pages.mekanik.tasks.today', compact('tasks'));
    }

    /**
     * Menampilkan riwayat pekerjaan yang sudah selesai
     */
    public function completed(Request $request)
    {
        $mekanik = Auth::user()->mekanik;

        $query = Booking::where('mekanik_id', $mekanik->id)
            ->whereIn('status', ['selesai', 'menunggu_pembayaran'])
            ->with(['customer.user', 'jenisService']);

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('tanggal_booking', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('tanggal_booking', '<=', $request->date_to);
        }

        $tasks = $query->orderBy('updated_at', 'desc')->paginate(15);

        return view('pages.mekanik.tasks.completed', compact('tasks'));
    }

    public function start(Booking $booking)
    {
        $this->authorizeMekanik($booking);

        // Cek apakah status booking adalah dijadwalkan
        if ($booking->status != 'dijadwalkan') {
            return redirect()->back()->with('error', 'Service tidak dapat dimulai. Status booking harus "Dijadwalkan".');
        }

        DB::beginTransaction();

        try {
            // Update status booking menjadi diproses
            $booking->update(['status' => 'diproses']);

            // Cek apakah sudah ada service record
            $existingService = Service::where('booking_id', $booking->id)->first();

            if (!$existingService) {
                // Buat record baru di tabel services
                Service::create([
                    'booking_id' => $booking->id,
                    'hasil_pemeriksaan' => null,
                    'tindakan_service' => null,
                    'status_service' => 'in_progress',
                    'tanggal_mulai' => now(),
                    'tanggal_selesai' => null,
                    'catatan_mekanik' => null,
                ]);
            } else {
                // Update existing service
                $existingService->update([
                    'status_service' => 'in_progress',
                    'tanggal_mulai' => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('mekanik.services.detail', $booking)
                ->with('success', 'Service telah dimulai. Silakan kerjakan service ini.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memulai service: ' . $e->getMessage());
        }
    }

    /**
     * Update status tugas
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $this->authorizeMekanik($booking);

        $request->validate([
            'status' => 'required|in:dijadwalkan,diproses,selesai,menunggu_pembayaran',
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
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
