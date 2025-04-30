<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\TeacherClass;
use App\Models\Userschool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userSchool = Userschool::where('user_id', $user->id)->first();

        if ($userSchool && $user) {
            $teacherClasses = DB::table('teacher_classes')
                ->join('classes', 'classes.class_id', '=', 'teacher_classes.class_id')
                ->where('teacher_classes.school_id', $userSchool->school_id)
                ->where('teacher_classes.user_id', $user->id)
                ->select('classes.*')
                ->get();
        } else {
            // Tangani jika $userSchool null
            $teacherClasses = collect(); // atau null, sesuai kebutuhan
        }

        $photos = Photo::orderBy('id', 'desc')->get();
        return view('guru.beranda', compact('user', 'userSchool', 'teacherClasses', 'photos'));
    }
}
