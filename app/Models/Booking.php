<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'customer_id',
        'mekanik_id',
        'jenis_service_id',
        'tanggal_booking',
        'waktu_booking',
        'keluhan',
        'status',
        'metode_pembayaran',
        'status_pembayaran',
        'total_bayar',
        'tanggal_pembayaran',
        'catatan',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
        'waktu_booking' => 'datetime',
        'tanggal_pembayaran' => 'date',
        'total_bayar' => 'decimal:2',
    ];

    // Boot method untuk generate booking code
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_code = 'BKG-' . strtoupper(Str::random(8));
        });
    }

    // Relasi
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class);
    }

    public function jenisService()
    {
        return $this->belongsTo(JenisService::class);
    }

    public function service()
    {
        return $this->hasOne(Service::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Helper methods
    public function updateTotalPayment()
    {
        $total = $this->jenisService->harga;

        if ($this->service && $this->service->spareparts) {
            $total += $this->service->spareparts->sum(function ($sparepart) {
                return $sparepart->pivot->subtotal;
            });
        }

        $this->update(['total_bayar' => $total]);
    }
}
