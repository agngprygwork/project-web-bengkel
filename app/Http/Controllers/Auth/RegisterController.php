<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:15'],
            'address' => ['nullable', 'string'],
        ]);

        // Gunakan database transaction untuk memastikan kedua record tersimpan
        \DB::beginTransaction();

        try {
            // Create User
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'customer', // Default role
            ]);

            // Create Customer record
            Customer::create([
                'user_id' => $user->id,
                'no_hp' => $validated['phone'] ?? null,
                'alamat' => $validated['address'] ?? null,
            ]);

            \DB::commit();

            // Login user
            Auth::login($user);

            return redirect()->route('customer.dashboard')
                ->with('success', 'Selamat datang! Akun Anda berhasil dibuat.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat registrasi: ' . $e->getMessage())
                ->withInput();
        }
    }
}
