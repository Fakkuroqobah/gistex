<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = User::where('role', 'user');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($data) {
                    $btn = `'<a href="#" class="btn btn-sm mr-2 btn-warning edit" data-id="'. $data->email .'" data-toggle="modal" data-target="#modal-edit" data-type="edit">Edit</a>'`;
                    
                    return '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->email .'">Delete</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('user.user');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|max:25|unique:user,email',
            'nama' => 'required|max:255',
            'password' => 'required|max:255'
        ]);

        try {
            $data = User::create([
                'email' => $request->email,
                'nama' => $request->nama,
                'password' => bcrypt($request->password),
                'role' => 'user'
            ]);

            return $this->res(201, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = User::where('role', 'user')->findOrFail($id);

        return $this->res(200, 'Berhasil', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'password' => 'nullable|max:255'
        ]);

        $data = User::where('role', 'user')->findOrFail($id);
        $oldPassword = $data->password;
        try {
            $data->update([
                'nama' => $request->nama,
                'password' => $request->filled('password') ? bcrypt($request->password) : $oldPassword
            ]);

            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = User::where('role', 'user')->findOrFail($id);
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