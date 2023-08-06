<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TahunPelajaranController extends Controller
{
    public function index()
    {
        echo view('admin.tahun-pelajaran');
    }
}
