<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKejadian extends Model
{
    use HasFactory;

    protected $table = 'data_laporan_kejadian';

    protected $fillable = [
        'jenis_bencana',
        'tgl_kejadian',
        'waktu_kejadian',
        'lokasi_kejadian',
        'penyebab_bencana',
        'dampak_bencana_rr',
        'dampak_bencana_rs',
        'dampak_bencana_rb',
        'korban_jiwa_md',
        'korban_jiwa_lr',
        'korban_jiwa_lb',
        'pengungsi_jiwa',
        'pengungsi_kk',
        'nama_pelapor',
        'telp_pelapor',
        'email_pelapor',
        'dokumentasi',
        'kondisi_umum',
        'kegiatan',
        'kendala',
        'created_at',
        'updated_at',
        'lat',
        'lng',
        'nomor_laporan',
        'status',
        'kabupaten',
        'kecamatan',
        'kelurahan'
    ];
}
