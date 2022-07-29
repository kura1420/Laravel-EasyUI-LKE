<?php

namespace App\Http\Controllers\Rest;

use App\Helpers\Generated;
use App\Http\Controllers\Controller;
use App\Http\Requests\LkeJawabanRequest;
use App\Models\LkeIndikator;
use App\Models\LkePengusulanSatker;
use Illuminate\Http\Request;

class LkeJawabanController extends Controller
{
    //
    public function index(Request $request)
    {
        $lke_pengusulan_id = $request->lke_pengusulan_id ?? NULL;

        $lkePengusulanSatker = LkePengusulanSatker::with(['predikats', 'satkers', 'lkes'])
            ->where('id', $lke_pengusulan_id)->first();

        $lkeIndikator = LkeIndikator::where('lke_id', $lkePengusulanSatker->lkes->id)
            ->orderBy('urutan', 'asc')
            ->get();
        
        $result = [
            'satker' => [
                'id' => $lkePengusulanSatker->id,
                'lke_nama' => $lkePengusulanSatker->lkes->nama,
                'predikat_nama' => $lkePengusulanSatker->predikats->nama,
                'satker_nama' => $lkePengusulanSatker->satkers->nama,
            ],
            'lke_pengisian' => Generated::buildTree($lkeIndikator),
        ];
        
        return response()->json($result);
    }

    public function store(LkeJawabanRequest $request)
    {
        # code...
    }

    public function show($lke_indikator_id)
    {
        # code...
    }
}
