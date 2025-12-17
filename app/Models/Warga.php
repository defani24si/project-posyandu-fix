<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga';
    protected $primaryKey = 'warga_id';

    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'rt',
        'rw',
        'nama_ayah',
        'nama_ibu',
        'no_telepon',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi ke tabel KaderPosyandu
     */
    public function kaderPosyandu()
    {
        return $this->hasMany(KaderPosyandu::class, 'warga_id', 'warga_id');
    }

    /**
     * Relasi ke tabel LayananPosyandu
     */
    public function layananPosyandu()
    {
        return $this->hasMany(LayananPosyandu::class, 'warga_id', 'warga_id');
    }

    /**
     * Relasi ke tabel CatatanImunisasi
     */
    public function catatanImunisasi()
    {
        return $this->hasMany(CatatanImunisasi::class, 'warga_id', 'warga_id');
    }

    /**
     * Accessor untuk nama lengkap dengan jenis kelamin
     */
    public function getNamaLengkapAttribute()
    {
        return $this->nama . ' (' . ($this->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') . ')';
    }

    /**
     * Accessor untuk umur
     */
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }

    /**
     * Route key name untuk model binding
     */
    public function getRouteKeyName()
    {
        return 'warga_id';
    }
}