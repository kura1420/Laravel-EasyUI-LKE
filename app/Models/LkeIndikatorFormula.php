<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkeIndikatorFormula extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $guarded = [];

    public function lke_indikator_targets()
    {
        return $this->belongsTo(LkeIndikator::class, 'lke_indikator_id_target');
    }
}
