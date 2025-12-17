<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananPosyandu extends Model
{
    use HasFactory;

    protected $table = 'layanan_posyandu';
    protected $primaryKey = 'layanan_id';

    protected $fillable = [
        'jadwal_id',
        'warga_id',
        'berat',
        'tinggi',
        'vitamin',
        'konseling',
    ];

    protected $casts = [
        'berat' => 'decimal:2',
        'tinggi' => 'decimal:2',
    ];

    /**
     * Relasi ke tabel JadwalPosyandu
     */
    public function jadwal()
    {
        return $this->belongsTo(JadwalPosyandu::class, 'jadwal_id', 'jadwal_id');
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
        return 'layanan_id';
    }
}