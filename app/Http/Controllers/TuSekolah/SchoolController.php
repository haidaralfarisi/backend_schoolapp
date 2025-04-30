<?php

namespace App\Http\Controllers\TuSekolah;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Userschool;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Jika SUPERADMIN, tampilkan semua sekolah
        if ($user->level === 'SUPERADMIN') {
            $userSchools = School::all();
        } else {
            // Jika user adalah TUSEKOLAH, hanya tampilkan sekolah yang terkait dengannya
            $userSchools = Userschool::where('user_id', $user->id)->get();
        }

        return view('tusekolah.school.index', compact('userSchools'));
    }
}
