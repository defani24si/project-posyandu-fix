<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanImunisasi extends Model
{
    use HasFactory;

    protected $table = 'catatan_imunisasi';
    protected $primaryKey = 'imunisasi_id';

    protected $fillable = [
        'warga_id',
        'jenis_vaksin',
        'tanggal',
        'lokasi',
        'nakes',
        'kartu_imunisasi_scan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

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
        return 'imunisasi_id';
    }
}