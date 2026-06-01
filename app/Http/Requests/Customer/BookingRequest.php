<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isCustomer();
    }

    public function rules(): array
    {
        return [
            'motor_brand' => 'required|string|max:50',
            'motor_type' => 'required|string|max:50',
            'license_plate' => 'required|string|max:10|regex:/^[A-Z]{1,2}\s?[0-9]{1,4}\s?[A-Z]{1,3}$/',
            'jenis_service_id' => 'required|exists:jenis_services,id',
            'mekanik_id' => 'nullable|exists:mekaniks,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'waktu_booking' => 'required',
            'keluhan' => 'required|string|min:10|max:500',
            'catatan' => 'nullable|string|max:200',
        ];
    }

    public function messages(): array
    {
        return [
            'license_plate.regex' => 'Format plat nomor tidak valid. Contoh: B 1234 ABC',
            'keluhan.min' => 'Keluhan minimal 10 karakter',
            'tanggal_booking.after_or_equal' => 'Tanggal booking tidak boleh kurang dari hari ini',
        ];
    }
}
