<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\School;
use App\Models\TeacherClass;
use App\Models\Userschool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{

    public function index()
    {
        $schools = School::all();
        $user = Auth::user();
        $userSchool = Userschool::where('user_id', $user->id)->first();

        $data_kelas = collect(); // default kosong

        if ($userSchool) {
            $data_kelas = DB::table('teacher_classes')
                ->join('classes', 'classes.class_id', '=', 'teacher_classes.class_id')
                ->where('teacher_classes.school_id', $userSchool->school_id)
                ->where('teacher_classes.user_id', $user->id)
                ->select('classes.*')
                ->get();
        }

        return view('guru.class.index', [
            'schools' => $schools,
            'data_kelas' => $data_kelas,
            'hasRelasi' => $data_kelas->isNotEmpty(),
            'userSchool' => $userSchool,

        ]);
    }
}
