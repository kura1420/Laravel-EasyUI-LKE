<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\Requests\LkeIndikatorJawabanRequest;
use App\Models\LkeIndikatorJawaban;
use Illuminate\Http\Request;

class LkeIndikatorJawabanController extends Controller
{
    //
    public function index(Request $request)
    {
        $lke_indikator_id = $request->lke_indikator_id ?? NULL;

        $result = LkeIndikatorJawaban::where('lke_indikator_id', $lke_indikator_id)
            ->get();
        
        return response()->json($result, 200);
    }

    public function store(LkeIndikatorJawabanRequest $request)
    {        
        LkeIndikatorJawaban::updateOrCreate(
            [
                // 'id' => $request->id,
                'urutan' => $request->j_urutan,
                'lke_id' => $request->lke_id,
                'lke_indikator_id' => $request->lke_indikator_id,
            ],
            [
                'jawaban' => $request->j_jawaban,
                'nilai' => $request->j_nilai,
                'penjelasan' => $request->j_penjelasan,
                'aktif' => $request->aktif == 'true' ? 1 : 0,
            ]
        );

        $status = $request->id ? 200 : 201;

        return response()->json('OK', $status);
    }

    public function show($id)
    {
        $row = LkeIndikatorJawaban::find($id);

        return $row;
    }
    
    public function destroy($id)
    {
        LkeIndikatorJawaban::find($id)->delete();

        return response()->json('OK', 200);
    }
}
