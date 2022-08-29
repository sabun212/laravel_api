<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'kegiatan_harian',
        'user_id',
        'tanggal',
        'keterangan'

    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
