<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    use HasFactory;

    protected $table = 'posyandu';

    protected $primaryKey = 'posyandu_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama', 'alamat', 'rt', 'rw', 'kontak', 'foto', 'files'
    ];
}