<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JalurKomunikasi extends Model
{
    use HasFactory;
    
    protected $table = 'm_jalur_komunikasi';
    
    protected $fillable = [
        'is_deleted', 'deleted_by', 'deleted_at',
    ];
}