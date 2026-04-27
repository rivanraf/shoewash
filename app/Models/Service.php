<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    /**
     * Tetap menggunakan guarded empty untuk fleksibilitas mass assignment.
     * Pastikan Anda sudah menjalankan migrasi untuk kolom 'is_active'.
     */
    protected $guarded = [];

    /**
     * Casts atribut agar Laravel otomatis mengenali is_active sebagai boolean.
     * Ini memudahkan saat pengecekan if($service->is_active).
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Mendefinisikan relasi One-to-Many.
     * Satu Service (Layanan) bisa memiliki banyak Bookings (Pesanan).
     * Logika ini tetap dipertahankan agar fitur proteksi hapus di Controller tetap jalan.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}