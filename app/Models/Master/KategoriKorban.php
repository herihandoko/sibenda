<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKorban extends Model
{
    use HasFactory;
    
    protected $table = 'm_kategori_korban';
    
    protected $fillable = [
        'is_deleted', 'deleted_by', 'deleted_at',
    ];
}