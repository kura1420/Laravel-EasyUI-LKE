<?php

namespace App\Http\Controllers\Rest;

use App\Helpers\Generated;
use App\Http\Controllers\Controller;
use App\Http\Requests\LkeIndikatorRequest;
use App\Models\LkeIndikator;
use Illuminate\Http\Request;

class LkeIndikatorController extends Controller
{
    //
    public function index(Request $request)
    {
        $lke = $request->lke_id ?? NULL;
        $page = $request->page ?? 1;
        $rows = $request->rows ?? 10;
        $sortOrder = $request->sortOrder ?? 'asc';
        $sortName = $request->sortName ?? NULL;
        $search = $request->search ?? NULL;

        $table = LkeIndikator::where('lke_id', $lke)
            ->select('*');

        if ($sortName) {
            $result = $table->orderBy($sortName, $sortOrder)->paginate($rows);
        } elseif ($search) {
            $result = $table
                ->where('kode', 'like', "%{$search}%")
                ->orWhere('lke_id', $lke)
                ->where('alias', 'like', "%{$search}%")
                ->orWhere('lke_id', $lke)
                ->where('indikator', 'like', "%{$search}%")
                ->orWhere('lke_id', $lke)
                ->where('nilai', 'like', "%{$search}%")
                ->get();
        } else {
            $data = $table->orderBy('urutan', 'asc')
                ->get();

            $result = Generated::buildTree($data);
        }
        
        return response()->json($result, 200);
    }

    public function store(LkeIndikatorRequest $request)
    {
        LkeIndikator::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'urutan' => $request->i_urutan,
                'urutan_tampilkan' => $request->urutan_tampilkan == 'true' ? 1 : 0,
                'kode' => $request->i_kode,
                'alias' => $request->i_alias,
                'indikator' => $request->i_indikator,
                'penjelasan' => $request->i_penjelasan,
                'aktif' => $request->aktif == 'true' ? 1 : 0,
                'nilai' => $request->i_nilai,
                'parent' => $request->i_parent,
                'tipe_jawaban' => $request->i_tipe_jawaban,
                'lke_id' => $request->i_lke_id,
            ]
        );

        $status = $request->id ? 200 : 201;

        return response()->json('OK', $status);
    }

    public function show($id)
    {
        $row = LkeIndikator::find($id);

        return $row;
    }
    
    public function destroy($id)
    {
        LkeIndikator::find($id)->delete();

        return response()->json('OK', 200);
    }

    public function lists()
    {
        $rows = LkeIndikator::where('aktif', 1)
            ->orderBy('urutan', 'asc')
            ->get();

        return response()->json($rows);
    }

    public function parent($lke_id)
    {
        $rows = LkeIndikator::where('lke_id', $lke_id)
            ->where('aktif', 1)
            ->orderBy('urutan', 'asc')
            ->get()
            ->map(function ($row) {
                $row->text = $row->indikator;

                return $row;
            });

        $result = Generated::buildTree($rows);

        return response()->json($result);
    }
}
