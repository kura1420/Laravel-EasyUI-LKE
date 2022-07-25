<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\Requests\LkeIndikatorFormulaRequest;
use App\Models\LkeIndikatorFormula;
use Illuminate\Http\Request;

class LkeIndikatorFormulaController extends Controller
{
    //
    public function index(Request $request)
    {
        $lke_indikator_id = $request->lke_indikator_id ?? NULL;

        $result = LkeIndikatorFormula::with(['lke_indikator_targets'])
            ->where('lke_indikator_id', $lke_indikator_id)
            ->get()
            ->map(function ($row) {
                if ($row->lke_indikator_targets) {
                    $row->indikator = $row->lke_indikator_targets->indikator;
                } else {
                    $row->indikator = null;
                }

                return $row;
            });
        
        return response()->json($result, 200);
    }

    public function store(LkeIndikatorFormulaRequest $request)
    {        
        LkeIndikatorFormula::updateOrCreate(
            [
                // 'id' => $request->id,
                'lke_id' => $request->lke_id,
                'lke_indikator_id' => $request->lke_indikator_id,
                'lke_indikator_id_target' => $request->f_lke_indikator_id_target,
            ],
            [
                'urutan' => $request->f_urutan,
                'rumus' => $request->f_rumus,
                'nilai_maksimal' => $request->nilai_maksimal == 'true' ? 1 : 0,
                'nilai_maksimal_mengurangi' => $request->nilai_maksimal_mengurangi == 'true' ? 1 : 0,
                'tipe_penilaian' => $request->f_tipe_penilaian,
                'nilai_bilangan' => $request->f_nilai_bilangan,
                'nilai_bawaaan' => $request->f_nilai_bawaaan,
                'keterangan' => $request->f_keterangan,
            ]
        );

        $status = $request->id ? 200 : 201;

        return response()->json('OK', $status);
    }

    public function show($id)
    {
        $row = LkeIndikatorFormula::find($id);

        return $row;
    }
    
    public function destroy($id)
    {
        LkeIndikatorFormula::find($id)->delete();

        return response()->json('OK', 200);
    }
}
