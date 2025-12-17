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
        Schema::create('layanan_posyandu', function (Blueprint $table) {
            $table->id('layanan_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->unsignedBigInteger('warga_id');
            $table->decimal('berat', 5, 2)->nullable();
            $table->decimal('tinggi', 5, 2)->nullable();
            $table->string('vitamin')->nullable();
            $table->text('konseling')->nullable();
            $table->timestamps();

            $table->foreign('jadwal_id')->references('jadwal_id')->on('jadwal_posyandu')->onDelete('cascade');
            $table->foreign('warga_id')->references('warga_id')->on('warga')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_posyandu');
    }
};
