<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisService extends Model
{
    use HasFactory;

    protected $table = 'jenis_services';

    protected $fillable = [
        'nama_service',
        'harga',
        'deskripsi',
        'estimasi_waktu',
        'is_active',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relasi
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
