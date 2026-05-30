<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sparepart extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_sparepart',
        'nama_sparepart',
        'merk',
        'stok',
        'stok_minimum',
        'harga_beli',
        'harga_jual',
        'satuan',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sparepart) {
            if (empty($sparepart->kode_sparepart)) {
                $sparepart->kode_sparepart = 'SP-' . strtoupper(Str::random(6));
            }
        });
    }

    // Relasi
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_spareparts')
            ->withPivot('jumlah', 'subtotal')
            ->withTimestamps();
    }

    // Scopes
    public function scopeLowStock($query)
    {
        return $query->whereRaw('stok <= stok_minimum');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper methods
    public function reduceStock($quantity)
    {
        if ($this->stok >= $quantity) {
            $this->decrement('stok', $quantity);
            return true;
        }
        return false;
    }

    public function addStock($quantity)
    {
        $this->increment('stok', $quantity);
    }
}
