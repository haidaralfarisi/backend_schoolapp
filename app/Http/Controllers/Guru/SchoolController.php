<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Userschool;

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

        return view('guru.school.index', compact('userSchools'));
    }
}
