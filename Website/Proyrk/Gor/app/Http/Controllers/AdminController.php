<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index(){
        return view('admin.index');
    }

    public function lapangan(){
        
        return view('admin.lapangan');
    }

    public function jadwal(){
        return view('admin.jadwal');
    }

    public function pemesanan(){
        return view('admin.pemesanan');
    }

    public function charts(){
        return view('admin.charts');
    }
}
