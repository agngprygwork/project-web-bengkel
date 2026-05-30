<?php
// app/Http/Controllers/Admin/JenisServiceController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisServiceController extends Controller
{
    /**
     * Display a listing of jenis services.
     */
    public function index(Request $request)
    {
        $query = JenisService::query();

        // Search by name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('nama_service', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
        }

        // Filter by active status
        if ($request->has('is_active') && $request->is_active != 'all') {
            $query->where('is_active', $request->is_active == 'active');
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('harga', '<=', $request->max_price);
        }

        $jenisServices = $query->orderBy('nama_service')->paginate(15);

        // Statistics
        $stats = [
            'total' => JenisService::count(),
            'active' => JenisService::where('is_active', true)->count(),
            'inactive' => JenisService::where('is_active', false)->count(),
            'avg_price' => JenisService::avg('harga'),
            'min_price' => JenisService::min('harga'),
            'max_price' => JenisService::max('harga'),
            'most_popular' => JenisService::withCount('bookings')
                ->orderBy('bookings_count', 'desc')
                ->first(),
        ];

        return view('pages.admin.jenis-services.index', compact('jenisServices', 'stats'));
    }

    /**
     * Show the form for creating a new jenis service.
     */
    public function create()
    {
        return view('pages.admin.jenis-services.create');
    }

    /**
     * Store a newly created jenis service.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_service' => 'required|string|max:255|unique:jenis_services',
            'harga' => 'required|numeric|min:0',
            'estimasi_waktu' => 'required|integer|min:15|max:480',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        DB::beginTransaction();

        try {
            $jenisService = JenisService::create([
                'nama_service' => $request->nama_service,
                'harga' => $request->harga,
                'estimasi_waktu' => $request->estimasi_waktu,
                'deskripsi' => $request->deskripsi,
                'is_active' => $request->is_active,
            ]);

            DB::commit();

            return redirect()->route('admin.jenis-services.index')
                ->with('success', "Service {$jenisService->nama_service} berhasil ditambahkan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menambahkan service: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified jenis service.
     */
    public function show(JenisService $jenisService)
    {
        $jenisService->load('bookings.customer.user');

        // Booking statistics
        $bookingStats = [
            'total' => $jenisService->bookings->count(),
            'completed' => $jenisService->bookings->where('status', 'selesai')->count(),
            'pending' => $jenisService->bookings->where('status', 'pending')->count(),
            'total_revenue' => $jenisService->bookings->where('status_pembayaran', 'lunas')->sum('total_bayar'),
        ];

        // Recent bookings
        $recentBookings = $jenisService->bookings()
            ->with(['customer.user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Monthly trend
        $monthlyTrend = $jenisService->bookings()
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(6)
            ->get();

        return view('pages.admin.jenis-services.show', compact('jenisService', 'bookingStats', 'recentBookings', 'monthlyTrend'));
    }

    /**
     * Show the form for editing the specified jenis service.
     */
    public function edit(JenisService $jenisService)
    {
        return view('pages.admin.jenis-services.edit', compact('jenisService'));
    }

    /**
     * Update the specified jenis service.
     */
    public function update(Request $request, JenisService $jenisService)
    {
        $request->validate([
            'nama_service' => 'required|string|max:255|unique:jenis_services,nama_service,' . $jenisService->id,
            'harga' => 'required|numeric|min:0',
            'estimasi_waktu' => 'required|integer|min:15|max:480',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        DB::beginTransaction();

        try {
            $jenisService->update([
                'nama_service' => $request->nama_service,
                'harga' => $request->harga,
                'estimasi_waktu' => $request->estimasi_waktu,
                'deskripsi' => $request->deskripsi,
                'is_active' => $request->is_active,
            ]);

            DB::commit();

            return redirect()->route('admin.jenis-services.index')
                ->with('success', "Service {$jenisService->nama_service} berhasil diperbarui.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui service: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified jenis service.
     */
    public function destroy(JenisService $jenisService)
    {
        // Check if service has any bookings
        if ($jenisService->bookings()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Service tidak dapat dihapus karena masih memiliki riwayat booking.');
        }

        DB::beginTransaction();

        try {
            $serviceName = $jenisService->nama_service;
            $jenisService->delete();

            DB::commit();

            return redirect()->route('admin.jenis-services.index')
                ->with('success', "Service {$serviceName} berhasil dihapus.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus service: ' . $e->getMessage());
        }
    }

    /**
     * Toggle active status
     */
    public function toggleActive(JenisService $jenisService)
    {
        DB::beginTransaction();

        try {
            $jenisService->update([
                'is_active' => !$jenisService->is_active
            ]);

            $status = $jenisService->is_active ? 'diaktifkan' : 'dinonaktifkan';

            DB::commit();

            return redirect()->back()
                ->with('success', "Service {$jenisService->nama_service} berhasil {$status}.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal mengubah status service: ' . $e->getMessage());
        }
    }
}
