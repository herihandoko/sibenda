<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusKorban extends Model
{
    use HasFactory;
    
    protected $table = 'm_status_korban';
    
    protected $fillable = [
        'is_deleted', 'deleted_by', 'deleted_at',
    ];
}