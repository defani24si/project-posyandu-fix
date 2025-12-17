<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// CLASS NAME HARUS SAMA DENGAN NAMA FILE
class CreatePosyanduTable extends Migration
{
    public function up()
    {
        Schema::create('posyandu', function (Blueprint $table) {        
            $table->id('posyandu_id');
            $table->string('nama', 100);
            $table->string('alamat', 100);
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('kontak', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posyandu');
    }
}