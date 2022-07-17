<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\Requests\PredikatRequest;
use App\Models\Predikat;
use Illuminate\Http\Request;

class PredikatController extends Controller
{
    //
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $rows = $request->rows ?? 10;
        $sortOrder = $request->sortOrder ?? 'asc';
        $sortName = $request->sortName ?? NULL;
        $search = $request->search ?? NULL;

        $table = Predikat::select('*');

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

    public function store(PredikatRequest $request)
    {        
        Predikat::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'nama' => $request->nama,
                'usulan' => $request->usulan,
                'keterangan' => $request->keterangan,
            ]
        );

        $status = $request->id ? 200 : 201;

        return response()->json('OK', $status);
    }

    public function show($id)
    {
        $row = Predikat::find($id);

        return $row;
    }
    
    public function destroy($id)
    {
        Predikat::find($id)->delete();

        return response()->json('OK', 200);
    }

    public function lists()
    {
        $rows = Predikat::orderBy('nama', 'asc')
            ->get()
            ->map(function ($row) {
                $row->text = $row->nama;

                return $row;
            });

        return response()->json($rows);
    }

    public function usulan()
    {
        $rows = Predikat::orderBy('usulan', 'asc')
            ->select('usulan')
            ->distinct()
            ->get()
            ->map(fn($row) => [
                'id' => $row->usulan, 
                'text' => $row->usulan,
            ]);

        return response()->json($rows);
    }
}
