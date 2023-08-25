<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    use HasFactory;

    protected $table = "dokumentasi";

    protected $fillable = [
        'id',
        'title',
        'description',
        'tanggal',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'image_5',
        'image_6',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'status',
        'slug'
    ];
}
