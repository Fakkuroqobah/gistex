<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use DataTables;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Barang::query();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($data) {
                    return '<a href="#" class="btn btn-sm mr-2 btn-warning edit" data-id="'. $data->kode_barang .'" data-toggle="modal" data-target="#modal-edit" data-type="edit">Edit</a>' .
                        '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->kode_barang .'">Delete</a>';
                })
                ->addColumn('harga', function($data) {
                    return 'Rp.' . number_format($data->harga);
                })
                ->rawColumns(['aksi', 'harga'])
                ->make(true);
        }

        return view('barang.barang');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|max:255|unique:master_barang,kode_barang',
            'nama_barang' => 'required|max:30',
            'satuan' => 'required|max:20',
            'qty' => 'required',
            'harga' => 'required',
        ]);

        try {
            $data = Barang::create([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'satuan' => $request->satuan,
                'qty' => $request->qty,
                'harga' => $request->harga
            ]);

            return $this->res(201, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = Barang::findOrFail($id);

        return $this->res(200, 'Berhasil', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|max:30',
            'satuan' => 'required|max:20',
            'qty' => 'required',
            'harga' => 'required',
        ]);

        $data = Barang::findOrFail($id);

        try {
            $data->update([
                'nama_barang' => $request->nama_barang,
                'satuan' => $request->satuan,
                'qty' => $request->qty,
                'harga' => $request->harga
            ]);

            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = Barang::findOrFail($id);
        try {
            $data->delete();

            return $this->res(200, 'Berhasil', $data);
        } catch (\Illuminate\Database\QueryException $ex) {
            if($ex->getCode() === '23000') 
                return $this->errorFk();
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }
}