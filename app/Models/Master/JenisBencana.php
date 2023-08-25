<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBencana extends Model
{
    use HasFactory;

    protected $table = 'm_jenis_bencana';

    protected $fillable = [
        'is_deleted', 'deleted_by', 'deleted_at', 'icon'
    ];

    public function getJenisBencana()
    {
        return $this->hasMany(DataBencana::class, 'jenis_bencana_id');
    }
}
