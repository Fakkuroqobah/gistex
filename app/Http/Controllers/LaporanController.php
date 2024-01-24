<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Retur;

class LaporanController extends Controller
{
    public function index()
    {
        // return view('pdf');
        return view('laporan');
    }

    public function download(Request $request)
    {
        $tipe = $request->tipe;
        $mulai = $request->filled('mulai') ? $request->mulai : null;
        $selesai = $request->filled('selesai') ? $request->selesai : null;

        if($request->tipe == 'barang') {
            $data = Barang::whereBetween('created_at', [$mulai, $selesai])->latest()->get();
            $pdf = Pdf::loadView('pdf', compact('data', 'tipe', 'mulai','selesai'));
            return $pdf->download('barang.pdf');
        }else if($request->tipe == 'masuk') {
            $data = BarangMasuk::with(['barang', 'supplier'])->whereBetween('tanggal_barang_masuk', [$mulai, $selesai])->latest()->get();
            $pdf = Pdf::loadView('pdf', compact('data', 'tipe', 'mulai','selesai'));
            return $pdf->download('barang masuk.pdf');
        }else if ($request->tipe == 'keluar') {
            $data = BarangKeluar::with(['barang.barang', 'customer'])->whereBetween('tanggal_penjualan', [$mulai, $selesai])->latest()->get();
            $pdf = Pdf::loadView('pdf', compact('data', 'tipe', 'mulai','selesai'));
            return $pdf->download('barang keluar.pdf');
        }else{
            $data = Retur::with(['penjualan.customer', 'penjualan.barang'])->whereBetween('tanggal_barang_retur', [$mulai, $selesai])->latest()->get();
            $pdf = Pdf::loadView('pdf', compact('data', 'tipe', 'mulai','selesai'));
            return $pdf->download('barang retur.pdf');
        }
    }
}