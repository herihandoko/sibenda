<?php

namespace App\Models\DataKorban;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKorban extends Model
{
    use HasFactory;
    
    protected $table = 'data_korban';
    
    protected $fillable = [
        'id_databencana',
        'nama_korban',
        'nik',
        'jns_kelamin',
        'tgl_lahir',
        'usia',
        'kategori_korban_id',
        'status_korban_id',
        'mengungsi',
        'lokasi_pengungsian_id',
        'disabilitas',
        'hamil',
        'usia_hamil',
        'jenis_hamil',
        'menyusui',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'rt',
        'rw',
        'lokasi_hilang',
        'ahli_waris',
        'alamat_rs',
        'keterangan',
        'is_deleted',
        'deleted_by',
        'deleted_at',
    ];
}