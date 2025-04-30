<?php

namespace App\Http\Controllers\TuSekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TuSekolahController extends Controller
{
    public function index()
    {
        return view('tusekolah.beranda'); // Sesuaikan dengan view yang akan dibuat
    }
}
