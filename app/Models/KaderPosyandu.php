<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaderPosyandu extends Model
{
    use HasFactory;

    protected $table = 'kader_posyandu';
    protected $primaryKey = 'kader_id';

    protected $fillable = [
        'posyandu_id',
        'warga_id',
        'peran',
        'mulai_tugas',
        'akhir_tugas',
    ];

    protected $casts = [
        'mulai_tugas' => 'date',
        'akhir_tugas' => 'date',
    ];

    /**
     * Relasi ke tabel Posyandu
     */
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id', 'posyandu_id');
    }

    /**
     * Relasi ke tabel Warga
     */
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    /**
     * Route key name untuk model binding
     */
    public function getRouteKeyName()
    {
        return 'kader_id';
    }
}