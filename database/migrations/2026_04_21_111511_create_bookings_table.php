<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // ID unik untuk tracking [cite: 68]
            $table->string('customer_name'); // Nama pelanggan [cite: 77]
            $table->string('customer_phone'); // WhatsApp untuk notifikasi
            $table->foreignId('service_id')->constrained(); // Relasi ke tabel services
            $table->string('shoe_brand'); // Jenis/Brand sepatu [cite: 57]
            $table->integer('total_price'); // Harga total
            $table->enum('payment_status', ['pending', 'success', 'failed'])->default('pending'); // Status Midtrans [cite: 74]
            $table->string('snap_token')->nullable(); // Token untuk pop-up Midtrans
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
