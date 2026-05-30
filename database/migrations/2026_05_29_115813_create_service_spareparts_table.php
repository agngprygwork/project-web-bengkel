<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_spareparts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('sparepart_id')->constrained()->onDelete('restrict');
            $table->integer('jumlah');
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            // Unique constraint untuk menghindari duplikasi
            $table->unique(['service_id', 'sparepart_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_spareparts');
    }
};
