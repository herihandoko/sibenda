<?php

namespace App\Models\DataBencana;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;
use App\Models\Master\JenisBencana;

class DataLokasi extends Model {

    use HasFactory,
        AutoNumberTrait;

    protected $table = 'data_lokasi_bencana';
    protected $fillable = [
        'id_databencana',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'lat',
        'long',
        'lokasi',
        'created_at',
        'created_by',
        'deleted_by',
        'deleted_at',
    ];

    public function getAutoNumberOptions() {
        return [
            'kode' => [
                'length' => 4
            ]
        ];
    }

    public function jenisBencanas() {
        return $this->hasOne(JenisBencana::class, 'id', 'jenis_bencana_id');
    }

}
