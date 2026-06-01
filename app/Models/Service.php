<?php
// app/Models/Service.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

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
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    // Relasi ke Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    // Relasi ke Sparepart melalui service_spareparts
    public function spareparts()
    {
        return $this->belongsToMany(Sparepart::class, 'service_spareparts', 'service_id', 'sparepart_id')
            ->withPivot('jumlah', 'price', 'subtotal')
            ->withTimestamps();
    }

    /**
     * Menghitung total biaya sparepart yang digunakan dalam service ini
     * 
     * @return float
     */
    public function calculateTotalSpareparts()
    {
        return $this->spareparts->sum(function ($sparepart) {
            return $sparepart->pivot->subtotal;
        });
    }

    /**
     * Menghitung total biaya sparepart dalam bentuk formatted Rupiah
     * 
     * @return string
     */
    public function getFormattedSparepartsTotalAttribute()
    {
        return 'Rp ' . number_format($this->calculateTotalSpareparts(), 0, ',', '.');
    }

    /**
     * Mendapatkan daftar sparepart dalam format string
     * 
     * @return string
     */
    public function getSparepartsListAttribute()
    {
        return $this->spareparts->map(function ($sparepart) {
            return $sparepart->nama_sparepart . ' (x' . $sparepart->pivot->jumlah . ')';
        })->implode(', ');
    }

    /**
     * Cek apakah service sudah selesai
     * 
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status_service === 'completed';
    }

    /**
     * Cek apakah service sedang berlangsung
     * 
     * @return bool
     */
    public function isInProgress()
    {
        return $this->status_service === 'in_progress';
    }

    /**
     * Mendapatkan durasi pengerjaan service dalam menit
     * 
     * @return int|null
     */
    public function getDurationInMinutes()
    {
        if ($this->tanggal_mulai && $this->tanggal_selesai) {
            return $this->tanggal_mulai->diffInMinutes($this->tanggal_selesai);
        }
        return null;
    }

    /**
     * Mendapatkan durasi dalam format jam:menit
     * 
     * @return string
     */
    public function getFormattedDurationAttribute()
    {
        $minutes = $this->getDurationInMinutes();
        if ($minutes) {
            $hours = floor($minutes / 60);
            $mins = $minutes % 60;
            return $hours . ' jam ' . $mins . ' menit';
        }
        return '-';
    }
}
