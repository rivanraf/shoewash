<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_phone',
        'service_id',
        'shoe_brand',
        'shoe_image',
        'total_price',
        'snap_token',
        'payment_status',
        'payment_method',
        'expired_at',
        'status',
    ];

    /**
     * Konversi otomatis string database ke objek Carbon (Waktu).
     * Ini mencegah error saat memanipulasi waktu expired.
     */
    protected $casts = [
        'expired_at' => 'datetime',
    ];

    /**
     * Relasi ke User (Pemilik Pesanan)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Service (Jenis Layanan)
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}