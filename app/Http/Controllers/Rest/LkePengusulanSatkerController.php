<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\Requests\LkePengusulanSatkerRequest;
use App\Models\LkePengusulanSatker;
use Illuminate\Http\Request;

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

        $table = LkePengusulanSatker::select('*');

        if ($sortName) {
            $result = $table->orderBy($sortName, $sortOrder)->paginate($rows);
        } elseif ($search) {
            $result = $table->where('nama', 'like', "%{$search}%")
                ->orWhere('usulan', 'like', "%{$search}%")
                ->paginate($rows);
        } else {
            $result = $table->paginate($rows);
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
}
