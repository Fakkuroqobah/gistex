<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data['barang'] = Barang::count();
        $data['pembelian'] = Pembelian::count();
        $data['user'] = User::where('role', 'user')->count();

        return view('dashboard', compact('data'));
    }
}