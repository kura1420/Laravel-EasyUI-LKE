<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\Requests\LkeIndikatorNilaiRequest;
use App\Models\LkeIndikatorNilai;
use Illuminate\Http\Request;

class LkeIndikatorNilaiController extends Controller
{
    //
    public function index(Request $request)
    {
        $lke_indikator_id = $request->lke_indikator_id ?? NULL;

        $result = LkeIndikatorNilai::with(['predikats'])
            ->where('lke_indikator_id', $lke_indikator_id)
            ->get()
            ->map(function ($row) {
                $row->predikat_nama = $row->predikats->nama;

                return $row;
            });
        
        return response()->json($result, 200);
    }

    public function store(LkeIndikatorNilaiRequest $request)
    {        
        $lke_predikat = \App\Models\LkePredikat::where('id', $request->lke_predikat_id)->first();

        LkeIndikatorNilai::updateOrCreate(
            [
                // 'id' => $request->id,
                'lke_id' => $request->lke_id,
                'lke_indikator_id' => $request->lke_indikator_id,
            ],
            [
                'nilai' => $request->nilai,
                'lke_predikat_id' => $lke_predikat->id,
                'predikat_id' => $lke_predikat->predikat_id,
            ]
        );

        $status = $request->id ? 200 : 201;

        return response()->json('OK', $status);
    }

    public function show($id)
    {
        $row = LkeIndikatorNilai::find($id);

        return $row;
    }
    
    public function destroy($id)
    {
        LkeIndikatorNilai::find($id)->delete();

        return response()->json('OK', 200);
    }
}
