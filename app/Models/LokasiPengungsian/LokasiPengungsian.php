<?php

namespace App\Models\LokasiPengungsian;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;
use App\Models\Master\JenisHunian;

class LokasiPengungsian extends Model
{
    use HasFactory, AutoNumberTrait;
    
    protected $table = 'data_lokasi_pengungsian';
    
    protected $fillable = [
        'id_databencana',
        'kode',
        'jenis_hunian_id',
        'kapasitas',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'rt',
        'rw',
        'keterangan',
        'is_deleted',
        'deleted_by',
        'deleted_at',
    ];
    
    public function getAutoNumberOptions()
    {
        return [
            'kode' => [
                'length' => 4
            ]
        ];
    }
    
    public function jenisHunians()
    {
        return $this->hasOne(JenisHunian::class, 'id', 'jenis_hunian_id');
    }
}