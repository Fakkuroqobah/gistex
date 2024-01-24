<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use DB;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $barang = Barang::all();

        if($request->ajax()) {
            $data = Pembelian::with('barang');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($data) {
                    return '<a href="#" class="btn btn-sm mr-2 btn-warning edit" data-id="'. $data->id .'" data-toggle="modal" data-target="#modal-edit" data-type="edit">Edit</a>' .
                        '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->id .'">Delete</a>';
                })
                ->addColumn('harga_pembelian', function($data) {
                    return 'Rp.' . number_format($data->harga_pembelian);
                })
                ->addColumn('harga', function($data) {
                    return 'Rp.' . number_format($data->harga);
                })
                ->addColumn('subtotal', function($data) {
                    return 'Rp.' . number_format($data->subtotal);
                })
                ->rawColumns(['aksi','harga','subtotal'])
                ->make(true);
        }

        return view('pembelian.pembelian', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_pembelian' => 'required|max:255|unique:pembelian_barang,nomor_pembelian',
            'kode_barang' => 'required|max:255',
            'satuan' => 'required|max:20',
            'qty' => 'required',
            'diskon' => 'nullable',
        ]);

        $barang = Barang::where('kode_barang', $request->kode_barang)->firstOrFail();
        if($barang->qty < $request->qty) {
            return $this->res(422, 'Gagal', 'Jumlah yang diminta tidak memenuhi stok saat ini');
        }

        DB::beginTransaction();
        try {
            $sum = $request->qty * $barang->harga;
            if(!is_null($request->diskon)) {
                $jumlahDiskon = $request->qty * ($request->diskon / 100);
                $sum = $sum - $jumlahDiskon;
            }

            $data = Pembelian::create([
                'nomor_pembelian' => $request->nomor_pembelian,
                'tanggal' => now(),
                'kode_barang' => $request->kode_barang,
                'satuan' => $request->satuan,
                'qty' => $request->qty,
                'harga' => $barang->harga,
                'diskon' => $request->diskon,
                'subtotal' => $sum,
            ]);

            $data = Barang::findOrFail($request->kode_barang);
            $data->update([
                'qty' => $data->qty - $request->qty
            ]);

            DB::commit();
            return $this->res(201, 'Berhasil', $data);
        } catch (\Throwable $e) {
            DB::rollback();
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = Pembelian::findOrFail($id);

        return $this->res(200, 'Berhasil', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'satuan' => 'required|max:20',
            'qty' => 'required',
            'diskon' => 'nullable',
        ]);

        $barang = Barang::where('kode_barang', $request->kode_barang)->firstOrFail();
        $data = Pembelian::findOrFail($id);

        $old = $data->qty + $barang->qty;
        if($old < $request->qty) {
            return $this->res(422, 'Gagal', 'Jumlah yang diminta tidak memenuhi stok saat ini');
        }

        DB::beginTransaction();
        try {
            $sum = $request->qty * $barang->harga;
            if(!is_null($request->diskon)) {
                $jumlahDiskon = $request->qty * ($request->diskon / 100);
                $sum = $sum - $jumlahDiskon;
            }
            
            $data->update([
                'tanggal' => now(),
                'satuan' => $request->satuan,
                'qty' => $request->qty,
                'harga' => $barang->harga,
                'diskon' => $request->diskon,
                'subtotal' => $sum,
            ]);

            $data = Barang::findOrFail($request->kode_barang);
            $data->update([
                'qty' => $old - $request->qty
            ]);

            DB::commit();
            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            DB::rollback();
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = Pembelian::findOrFail($id);
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

    public function download()
    {
        $data = Pembelian::all();
        $max = Pembelian::max('tanggal');
        $min = Pembelian::min('tanggal');

        $pdf = Pdf::loadView('pdf', compact('data', 'max', 'min'));
        return $pdf->download('barang.pdf');
    }
}