<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'booking_id',
        'order_id',
        'transaction_id',
        'amount',
        'status',
        'payment_type',
        'payment_method',
        'payment_details',
        'qr_code_url',
        'transaction_time',
        'settlement_time',
        'expiry_time',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'transaction_time' => 'datetime',
        'settlement_time' => 'datetime',
        'expiry_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_SETTLEMENT = 'settlement';
    const STATUS_CAPTURE = 'capture';
    const STATUS_DENY = 'deny';
    const STATUS_CANCEL = 'cancel';
    const STATUS_EXPIRE = 'expire';
    const STATUS_FAILURE = 'failure';

    // Payment type constants
    const TYPE_CREDIT_CARD = 'credit_card';
    const TYPE_BANK_TRANSFER = 'bank_transfer';
    const TYPE_QRIS = 'qris';
    const TYPE_GOPAY = 'gopay';
    const TYPE_SHOPEEPAY = 'shopeepay';
    const TYPE_OTHER_EWALLET = 'other_ewallet';

    /**
     * Relasi ke Booking
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Scope untuk payment pending
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope untuk payment sukses
     */
    public function scopeSuccess($query)
    {
        return $query->whereIn('status', [self::STATUS_SETTLEMENT, self::STATUS_CAPTURE]);
    }

    /**
     * Scope untuk payment gagal
     */
    public function scopeFailed($query)
    {
        return $query->whereIn('status', [self::STATUS_DENY, self::STATUS_CANCEL, self::STATUS_EXPIRE, self::STATUS_FAILURE]);
    }

    /**
     * Cek apakah payment sukses
     */
    public function isSuccessful()
    {
        return in_array($this->status, [self::STATUS_SETTLEMENT, self::STATUS_CAPTURE]);
    }

    /**
     * Cek apakah payment pending
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Cek apakah payment gagal
     */
    public function isFailed()
    {
        return in_array($this->status, [self::STATUS_DENY, self::STATUS_CANCEL, self::STATUS_EXPIRE, self::STATUS_FAILURE]);
    }

    /**
     * Cek apakah payment expired
     */
    public function isExpired()
    {
        return $this->status === self::STATUS_EXPIRE;
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get payment status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_SETTLEMENT, self::STATUS_CAPTURE => 'bg-green-100 text-green-800',
            self::STATUS_DENY, self::STATUS_FAILURE => 'bg-red-100 text-red-800',
            self::STATUS_CANCEL => 'bg-gray-100 text-gray-800',
            self::STATUS_EXPIRE => 'bg-orange-100 text-orange-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get payment status text
     */
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_SETTLEMENT => 'Selesai',
            self::STATUS_CAPTURE => 'Terkonfirmasi',
            self::STATUS_DENY => 'Ditolak',
            self::STATUS_CANCEL => 'Dibatalkan',
            self::STATUS_EXPIRE => 'Kadaluarsa',
            self::STATUS_FAILURE => 'Gagal',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get payment type text
     */
    public function getPaymentTypeTextAttribute()
    {
        return match ($this->payment_type) {
            self::TYPE_CREDIT_CARD => 'Kartu Kredit',
            self::TYPE_BANK_TRANSFER => 'Transfer Bank',
            self::TYPE_QRIS => 'QRIS',
            self::TYPE_GOPAY => 'GoPay',
            self::TYPE_SHOPEEPAY => 'ShopeePay',
            self::TYPE_OTHER_EWALLET => 'E-Wallet',
            default => ucfirst(str_replace('_', ' ', $this->payment_type)),
        };
    }
}
