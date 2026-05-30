<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spareparts', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sparepart')->unique();
            $table->string('nama_sparepart');
            $table->string('merk')->nullable();
            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(5);
            $table->decimal('harga_beli', 10, 2);
            $table->decimal('harga_jual', 10, 2);
            $table->string('satuan')->default('pcs');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['kode_sparepart', 'nama_sparepart']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spareparts');
    }
};
