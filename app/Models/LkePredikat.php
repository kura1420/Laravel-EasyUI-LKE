<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkePredikat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function predikats()
    {
        return $this->belongsTo(Predikat::class, 'predikat_id');
    }
}
