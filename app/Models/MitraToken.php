<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraToken extends Model
{
    use HasFactory;

    protected $table = 'mitra_tokens';

    protected $fillable = [
        'mitra_id',
        'access_token',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id', 'mitra_id');
    }
}
