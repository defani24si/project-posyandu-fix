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
        Schema::create('kader_posyandu', function (Blueprint $table) {
            $table->id('kader_id');
            $table->unsignedBigInteger('posyandu_id');
            $table->unsignedBigInteger('warga_id');
            $table->string('peran');
            $table->date('mulai_tugas');
            $table->date('akhir_tugas')->nullable();
            $table->timestamps();

            $table->foreign('posyandu_id')->references('posyandu_id')->on('posyandu')->onDelete('cascade');
            $table->foreign('warga_id')->references('warga_id')->on('warga')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kader_posyandu');
    }
};
