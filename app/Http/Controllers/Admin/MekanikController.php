<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mekanik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MekanikController extends Controller
{
    /**
     * Display a listing of mekaniks.
     */
    public function index(Request $request)
    {
        $query = Mekanik::with('user');

        // Search by name or spesialis
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('spesialis', 'like', "%{$search}%");
        }

        // Filter by spesialis
        if ($request->has('spesialis') && $request->spesialis) {
            $query->where('spesialis', $request->spesialis);
        }

        // Filter by active status (has user)
        if ($request->has('status')) {
            if ($request->status == 'active') {
                $query->whereHas('user', function ($q) {
                    $q->whereNotNull('email_verified_at');
                });
            }
        }

        $mekaniks = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistics
        $stats = [
            'total' => Mekanik::count(),
            'active' => Mekanik::whereHas('user', function ($q) {
                $q->whereNotNull('email_verified_at');
            })->count(),
            'spesialis_list' => Mekanik::select('spesialis')->distinct()->pluck('spesialis'),
            'avg_experience' => Mekanik::avg('pengalaman_tahun'),
        ];

        return view('pages.admin.mekaniks.index', compact('mekaniks', 'stats'));
    }

    /**
     * Show the form for creating a new mekanik.
     */
    public function create()
    {
        $spesialisOptions = [
            'Mesin' => 'Mesin',
            'Kelistrikan' => 'Kelistrikan',
            'Body & Cat' => 'Body & Cat',
            'Suspensi' => 'Suspensi',
            'Rem' => 'Rem',
            'Transmisi' => 'Transmisi',
            'General' => 'General',
        ];

        return view('pages.admin.mekaniks.create', compact('spesialisOptions'));
    }

    /**
     * Store a newly created mekanik.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'spesialis' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'pengalaman_tahun' => 'required|integer|min:0|max:50',
        ]);

        DB::beginTransaction();

        try {
            // Create User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mekanik',
                'email_verified_at' => now(), // Auto verify for admin created
            ]);

            // Create Mekanik record
            Mekanik::create([
                'user_id' => $user->id,
                'spesialis' => $request->spesialis,
                'no_hp' => $request->no_hp,
                'pengalaman_tahun' => $request->pengalaman_tahun,
            ]);

            DB::commit();

            return redirect()->route('admin.mekaniks.index')
                ->with('success', "Mekanik {$user->name} berhasil ditambahkan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menambahkan mekanik: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified mekanik.
     */
    public function show(Mekanik $mekanik)
    {
        $mekanik->load('user');

        // Get booking statistics
        $bookingStats = [
            'total' => $mekanik->bookings->count(),
            'completed' => $mekanik->bookings->where('status', 'selesai')->count(),
            'in_progress' => $mekanik->bookings->where('status', 'diproses')->count(),
            'pending' => $mekanik->bookings->where('status', 'pending')->count(),
            'total_revenue' => $mekanik->bookings->where('status_pembayaran', 'lunas')->sum('total_bayar'),
            'avg_rating' => 4.5, // Placeholder for rating system
        ];

        // Get recent bookings
        $recentBookings = $mekanik->bookings()
            ->with(['customer.user', 'jenisService'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get upcoming schedule
        $upcomingSchedule = $mekanik->bookings()
            ->where('status', 'dijadwalkan')
            ->whereDate('tanggal_booking', '>=', now())
            ->with(['customer.user', 'jenisService'])
            ->orderBy('tanggal_booking', 'asc')
            ->take(5)
            ->get();

        return view('pages.admin.mekaniks.show', compact('mekanik', 'bookingStats', 'recentBookings', 'upcomingSchedule'));
    }

    /**
     * Show the form for editing the specified mekanik.
     */
    public function edit(Mekanik $mekanik)
    {
        $mekanik->load('user');

        $spesialisOptions = [
            'Mesin' => 'Mesin',
            'Kelistrikan' => 'Kelistrikan',
            'Body & Cat' => 'Body & Cat',
            'Suspensi' => 'Suspensi',
            'Rem' => 'Rem',
            'Transmisi' => 'Transmisi',
            'General' => 'General',
        ];

        return view('pages.admin.mekaniks.edit', compact('mekanik', 'spesialisOptions'));
    }

    /**
     * Update the specified mekanik.
     */
    public function update(Request $request, Mekanik $mekanik)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $mekanik->user_id,
            'password' => 'nullable|string|min:8|confirmed',
            'spesialis' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'pengalaman_tahun' => 'required|integer|min:0|max:50',
        ]);

        DB::beginTransaction();

        try {
            // Update User
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $mekanik->user->update($userData);

            // Update Mekanik record
            $mekanik->update([
                'spesialis' => $request->spesialis,
                'no_hp' => $request->no_hp,
                'pengalaman_tahun' => $request->pengalaman_tahun,
            ]);

            DB::commit();

            return redirect()->route('admin.mekaniks.index')
                ->with('success', "Mekanik {$mekanik->user->name} berhasil diperbarui.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui mekanik: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified mekanik.
     */
    public function destroy(Mekanik $mekanik)
    {
        DB::beginTransaction();

        try {
            $mekanikName = $mekanik->user->name;

            // User akan terhapus otomatis karena cascade
            $mekanik->user->delete();

            DB::commit();

            return redirect()->route('admin.mekaniks.index')
                ->with('success', "Mekanik {$mekanikName} berhasil dihapus.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus mekanik: ' . $e->getMessage());
        }
    }
}
