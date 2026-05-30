<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'hasil_pemeriksaan',
        'tindakan_service',
        'status_service',
        'tanggal_mulai',
        'tanggal_selesai',
        'catatan_mekanik',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    // Relasi
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function spareparts()
    {
        return $this->belongsToMany(Sparepart::class, 'service_spareparts')
            ->withPivot('jumlah', 'subtotal')
            ->withTimestamps();
    }

    // Helper methods
    public function calculateTotalSpareparts()
    {
        return $this->spareparts->sum(function ($sparepart) {
            return $sparepart->pivot->subtotal;
        });
    }
}
