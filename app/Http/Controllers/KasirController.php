<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class KasirController extends Controller
{
    public function index()
    {
        //PROTECT HALAMAN
        $user = Session::get('user');

        if(!$user || $user->role != 'kasir'){
            return redirect('/login');
        }

        // tampil halaman
        return view('inputkasir');
    }
}