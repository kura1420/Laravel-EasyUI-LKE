<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\Requests\SatkerRequest;
use App\Models\Satker;
use Illuminate\Http\Request;

class SatkerController extends Controller
{
    //
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $rows = $request->rows ?? 10;
        $sortOrder = $request->sortOrder ?? 'asc';
        $sortName = $request->sortName ?? NULL;
        $search = $request->search ?? NULL;

        $table = Satker::select('*');

        if ($sortName) {
            $result = $table->orderBy($sortName, $sortOrder)->paginate($rows);
        } elseif ($search) {
            $result = $table->where('kode', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%")
                ->orWhere('provinsi', 'like', "%${$search}%")
                ->orWhere('kota', 'like', "%${$search}%")
                ->orWhere('email', 'like', "%${$search}%")
                ->orWhere('telp', 'like', "%${$search}%")
                ->paginate($rows);
        } else {
            $result = $table->paginate($rows);
        }
        
        return response()->json($result, 200);
    }

    public function store(SatkerRequest $request)
    {        
        Satker::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'kode' => strtoupper($request->kode),
                'nama' => $request->nama,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'alamat' => $request->alamat,
                'email' => strtolower($request->email),
                'telp' => $request->telp,
            ]
        );

        $status = $request->id ? 200 : 201;

        return response()->json('OK', $status);
    }

    public function show($id)
    {
        $row = Satker::find($id);

        return $row;
    }
    
    public function destroy($id)
    {
        Satker::find($id)->delete();

        return response()->json('OK', 200);
    }

    public function lists()
    {
        $rows = Satker::where('active', 1)
            ->orderBy('nama', 'asc')
            ->select('id', 'nama as text')
            ->get();

        return response()->json($rows);
    }

    public function provinsi()
    {
        $rows = Satker::orderBy('provinsi', 'asc')
            ->select('provinsi')
            ->distinct()
            ->get()
            ->map(fn($row) => [
                'id' => $row->provinsi, 
                'text' => $row->provinsi,
            ]);

        return response()->json($rows);
    }

    public function kota()
    {
        $rows = Satker::orderBy('kota', 'asc')
            ->select('kota')
            ->distinct()
            ->get()
            ->map(fn($row) => [
                'id' => $row->kota, 
                'text' => $row->kota,
            ]);

        return response()->json($rows);
    }
}
