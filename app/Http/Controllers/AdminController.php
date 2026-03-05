<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        $user = Session::get('user');

        if(!$user || $user->role != 'admin'){
            return redirect('/login');
        }

        return view('verifadmin');
    }
}