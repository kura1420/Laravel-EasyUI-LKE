<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkePengusulanSatker extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $guarded = [];
    
    public function predikats()
    {
        return $this->belongsTo(Predikat::class, 'predikat_id');
    }

    public function satkers()
    {
        return $this->belongsTo(Satker::class, 'satker_id');
    }

    public function lkes()
    {
        return $this->belongsTo(Lke::class, 'lke_id');
    }
}
