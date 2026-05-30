<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of users (customers only).
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')->with('customer');

        // Search by name or email
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status (has customer record or not)
        if ($request->has('has_profile')) {
            if ($request->has_profile == 'yes') {
                $query->has('customer');
            } elseif ($request->has_profile == 'no') {
                $query->doesntHave('customer');
            }
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistics
        $stats = [
            'total' => User::where('role', 'customer')->count(),
            'active' => User::where('role', 'customer')->has('customer')->count(),
            'inactive' => User::where('role', 'customer')->doesntHave('customer')->count(),
            'new_this_month' => User::where('role', 'customer')
                ->whereMonth('created_at', now()->month)
                ->count(),
        ];

        return view('pages.admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('pages.admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Create User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer',
            ]);

            // Create Customer record
            Customer::create([
                'user_id' => $user->id,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', "Customer {$user->name} berhasil ditambahkan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menambahkan customer: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        if ($user->role !== 'customer') {
            abort(404, 'User not found');
        }

        $user->load('customer', 'customer.bookings.jenisService');

        $bookingStats = [
            'total' => $user->customer->bookings->count(),
            'completed' => $user->customer->bookings->where('status', 'selesai')->count(),
            'pending' => $user->customer->bookings->where('status', 'pending')->count(),
            'total_spent' => $user->customer->bookings->where('status_pembayaran', 'lunas')->sum('total_bayar'),
        ];

        return view('pages.admin.users.show', compact('user', 'bookingStats'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        if ($user->role !== 'customer') {
            abort(404, 'User not found');
        }

        $user->load('customer');

        return view('pages.admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        if ($user->role !== 'customer') {
            abort(404, 'User not found');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
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

            $user->update($userData);

            // Update or Create Customer
            $user->customer()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'no_hp' => $request->no_hp,
                    'alamat' => $request->alamat,
                ]
            );

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', "Customer {$user->name} berhasil diperbarui.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui customer: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        if ($user->role !== 'customer') {
            abort(404, 'User not found');
        }

        DB::beginTransaction();

        try {
            $userName = $user->name;

            // Customer akan terhapus otomatis karena cascade
            $user->delete();

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', "Customer {$userName} berhasil dihapus.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus customer: ' . $e->getMessage());
        }
    }
}
