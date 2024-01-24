<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class LoginController extends Controller
{
    public function viewLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $check = User::where('email', $request->email)->first();
        if($check) {
            if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->back()->with('danger', 'Email atau password salah');
            }
    
            if(Auth::check()) {
                $check->update([
                    'last_login' => now()
                ]);
                return redirect()->route('dashboard');
            }else{
                return redirect()->back()->with('danger', 'Email atau password salah');
            }
        }

        return redirect()->back()->with('danger', 'Email atau password salah');
    }

    public function logout() 
    {
        if(Auth::check()) Auth::logout();

        return redirect('/');
    }
}