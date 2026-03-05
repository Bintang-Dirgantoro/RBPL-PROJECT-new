<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $user = DB::table('users')
            ->where('username',$username)
            ->first();

        if(!$user){
            return back()->with('error','User tidak ada');
        }

        if($user->pass != $password){
            return back()->with('error','Password salah');
        }

        Session::put('user',$user);

        // REDIRECT BERDASARKAN ROLE
        if($user->role == 'kasir'){
            return redirect('/inputkasir');
        }

        if($user->role == 'admin'){
            return redirect('/verifadmin');
        }

        if($user->role == 'owner'){
            return redirect('/dashboardowner');
        }

        return redirect('/login');
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/login');
    }
}