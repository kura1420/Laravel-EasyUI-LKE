<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\Requests\LkePengusulanSatkerRequest;
use App\Models\LkePengusulanSatker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LkePengusulanSatkerController extends Controller
{
    //
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $rows = $request->rows ?? 10;
        $sortOrder = $request->sortOrder ?? 'asc';
        $sortName = $request->sortName ?? NULL;
        $search = $request->search ?? NULL;

        $table = LkePengusulanSatker::with(['predikats', 'satkers'])
            ->select('*');

        if ($sortName) {
            $result = $table->orderBy($sortName, $sortOrder)->paginate($rows);
        } elseif ($search) {
            $result = $table->where('nama', 'like', "%{$search}%")
                ->orWhere('usulan', 'like', "%{$search}%")
                ->paginate($rows)
                ->map(function ($row) {
                    $row->satker_nama = $row->satkers->nama;
                    $row->predikat_nama = $row->predikats->nama;

                    return $row;
                });
        } else {
            $result = $table->paginate($rows)
                ->map(function ($row) {
                    $row->satker_nama = $row->satkers->nama;
                    $row->predikat_nama = $row->predikats->nama;

                    return $row;
                });
        }
        
        return response()->json($result, 200);
    }

    public function store(LkePengusulanSatkerRequest $request)
    {        
        LkePengusulanSatker::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'aktif' => $request->aktif == 'true' ? 1 : 0,
                'satker_id' => $request->satker_id,
                'lke_id' => $request->lke_id,
                'predikat_id' => $request->predikat_id,
            ]
        );

        $status = $request->id ? 200 : 201;

        return response()->json('OK', $status);
    }

    public function show($id)
    {
        $row = LkePengusulanSatker::find($id);

        return $row;
    }
    
    public function destroy($id)
    {
        LkePengusulanSatker::find($id)->delete();

        return response()->json('OK', 200);
    }

    public function listPengisianLke(Request $request, $lke_id)
    {
        $search = $request->search ?? NULL;

        $whereStmt = " AND lps.lke_id = '$lke_id'";

        if ($search) {
            $whereStmt .= " AND (l.nama LIKE '%$search%' OR s.kode LIKE '%$search%' OR s.nama LIKE '%$search%')";
        }

        $sql = "SELECT
            lps.id,
            l.nama AS lke_nama,
            s.kode AS satker_kode, s.nama AS satker_nama,
            COUNT(li.id) AS total_indikator
        FROM lke_pengusulan_satkers lps
        INNER JOIN lkes l ON lps.lke_id = l.id
        INNER JOIN satkers s ON lps.satker_id = s.id
        INNER JOIN lke_indikators li ON lps.lke_id = li.lke_id
        WHERE lps.aktif = 1 $whereStmt
        GROUP BY lps.id, l.nama, s.nama";

        $rows = DB::select($sql);

        return response()->json($rows);
    }
}
