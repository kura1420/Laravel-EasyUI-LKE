<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\Requests\LkeRequest;
use App\Models\Lke;
use App\Models\LkePredikat;
use Illuminate\Http\Request;

class LkeController extends Controller
{
    //
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $rows = $request->rows ?? 10;
        $sortOrder = $request->sortOrder ?? 'asc';
        $sortName = $request->sortName ?? NULL;
        $search = $request->search ?? NULL;

        $table = Lke::select('*');

        if ($sortName) {
            $result = $table->orderBy($sortName, $sortOrder)->paginate($rows);
        } elseif ($search) {
            $result = $table->where('nama', 'like', "%{$search}%")
                ->orWhere('tahun', 'like', "%{$search}%")
                ->paginate($rows);
        } else {
            $result = $table->paginate($rows);
        }
        
        return response()->json($result, 200);
    }

    public function store(LkeRequest $request)
    {        
        $predikats = json_decode($request->predikats, TRUE);

        $lke = Lke::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'nama' => $request->nama,
                'aktif' => $request->aktif == 'true' ? 1 : 0,
                'keterangan' => $request->keterangan,
                'tahun' => $request->tahun,
            ]
        );

        if (!empty($predikats)) {
            foreach ($predikats as $key => $predikat) {
                LkePredikat::updateOrCreate(
                    [
                        'id' => $predikat['id'],
                    ],
                    [
                        'nilai_minimal' => $predikat['nilai_minimal'],
                        'predikat_id' => $predikat['predikat_id'],
                        'lke_id' => $lke->id,
                    ]
                );
            }
        }

        $status = $request->id ? 200 : 201;

        return response()->json($lke, $status);
    }

    public function show($id)
    {
        $row = Lke::find($id);

        return $row;
    }
    
    public function destroy($id)
    {
        Lke::find($id)->delete();

        return response()->json('OK', 200);
    }

    public function lists()
    {
        $rows = Lke::where('aktif', 1)
            ->orderBy('nama', 'asc')
            ->get();

        return response()->json($rows);
    }

    public function predikatList($fk)
    {
        $rows = LkePredikat::where('lke_id', $fk)
            ->with(['predikats'])
            ->get()
            ->map(function ($row) {
                $predikat = $row->predikats;

                $row->predikat_nama = $predikat->nama ?? NULL;
                $row->predikat_usulan = $predikat->usulan ?? NULL;

                return $row;
            });

        return response()->json($rows);
    }

    public function predikatDestroy($id)
    {
        LkePredikat::find($id)->delete();

        return response()->json('OK', 200);
    }
}
