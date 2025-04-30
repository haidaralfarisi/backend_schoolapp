<?php

namespace App\Http\Controllers\TuSekolah;

use App\Http\Controllers\Controller;
use App\Models\Eraport;
use App\Models\Ereport;
use Illuminate\Http\Request;

class EreportController extends Controller
{
    public function index()
    {
        $ereports = Ereport::all(); // Mengambil semua data student
        return view('tusekolah.ereport.index', compact('ereports'));
    }

    
}
