<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class OwnerController extends Controller
{
    public function index()
    {
        $user = Session::get('user');

        if(!$user || $user->role != 'owner'){
            return redirect('/login');
        }

        return view('Dashboardowner');
    }
}