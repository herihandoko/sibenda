<?php

namespace App\Models\DataBencana;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;
use App\Models\Master\JenisBencana;

class DataBencana extends Model
{
    use HasFactory, AutoNumberTrait;
    
    protected $table = 'data_bencana';
    
    protected $fillable = [
        'kode',
        'jenis_bencana_id',
        'luas_genangan',
        'tinggi_genangan',
        'tgl_kejadian',
        'jam_kejadian',
        'kondisi_cuaca',
        'potensi_susulan',
        'penyebab_bencana',
        'deskripsi_bencana',
        'akses_lokasi',
        'sarana_trans',
        'jalur_komunikasi_id',
        'keadaan_listrik',
        'keadaan_air',
        'faskes',
        'is_deleted',
        'deleted_by',
        'deleted_at',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'image_5',
        'image_6',
    ];
    
    public function getAutoNumberOptions()
    {
        return [
            'kode' => [
                'length' => 4
            ]
        ];
    }
    
    public function jenisBencanas()
    {
        return $this->hasOne(JenisBencana::class, 'id', 'jenis_bencana_id');
    }
}