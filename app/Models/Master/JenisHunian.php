<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisHunian extends Model
{
    use HasFactory;
    
    protected $table = 'm_jenis_hunian';
    
    protected $fillable = [
        'is_deleted', 'deleted_by', 'deleted_at',
    ];
}