<?php
// app/Http/Controllers/Customer/ProfileController.php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display customer profile.
     */
    public function index()
    {
        $customer = Auth::user()->customer;

        if (!$customer) {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Data customer tidak ditemukan.');
        }

        $user = Auth::user();

        return view('pages.customer.profile.index', compact('user', 'customer'));
    }

    /**
     * Update customer profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $customer = $user->customer;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            // Update user
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update or create customer profile
            $customer->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'no_hp' => $request->phone,
                    'alamat' => $request->address,
                ]
            );

            DB::commit();

            return redirect()->route('customer.profile.index')
                ->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui profil: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Change customer password.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Password saat ini tidak sesuai.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('customer.profile.index')
            ->with('success', 'Password berhasil diubah.');
    }
}
