<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_posyandu', function (Blueprint $table) {
            $table->id('jadwal_id');
            $table->unsignedBigInteger('posyandu_id');
            $table->foreign('posyandu_id')
                  ->references('posyandu_id')
                  ->on('posyandu')
                  ->onDelete('cascade');

            $table->date('tanggal');
            $table->string('tema');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('jadwal_posyandu');
    }
};
