<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('mekanik_id')->nullable()->constrained('mekaniks')->onDelete('set null');
            $table->foreignId('jenis_service_id')->constrained('jenis_services');
            $table->date('tanggal_booking');
            $table->time('waktu_booking');
            $table->text('keluhan');
            $table->enum('status', ['pending', 'dijadwalkan', 'diproses', 'menunggu_pembayaran', 'selesai', 'ditolak'])->default('pending');
            $table->string('metode_pembayaran')->nullable();
            $table->enum('status_pembayaran', ['pending', 'lunas', 'gagal'])->default('pending');
            $table->decimal('total_bayar', 12, 2)->default(0);
            $table->date('tanggal_pembayaran')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Index untuk optimasi query
            $table->index(['status', 'tanggal_booking']);
            $table->index('booking_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
