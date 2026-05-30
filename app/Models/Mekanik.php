<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mekanik extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'spesialis',
        'no_hp',
        'pengalaman_tahun',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function completedServices()
    {
        return $this->hasManyThrough(Service::class, Booking::class);
    }
}
