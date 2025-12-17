<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPosyandu extends Model
{
    use HasFactory;

    protected $table = 'jadwal_posyandu';

    protected $primaryKey = 'jadwal_id';

    protected $fillable = [
        'posyandu_id',
        'tanggal',
        'tema',
        'keterangan',
        'poster_kegiatan',
    ];

    /**
     * Relasi ke tabel Posyandu.
     */
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id', 'posyandu_id');
    }

    /**
     * Gunakan kolom jadwal_id untuk route model binding.
     */
    public function getRouteKeyName()
    {
        return 'jadwal_id';
    }
}
