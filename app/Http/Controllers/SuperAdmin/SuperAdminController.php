<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\LessonPlan;
use App\Models\Photo;
use App\Models\School;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index()
    {
        $schools = School::all();

        $classes = ClassModel::all();

        $photos = Photo::all();

        $videos = Video::all();

        $lsplan = LessonPlan::all();


        $schoolCounts = $schools->count();
        $lscounts = $lsplan->count();
        $classCounts = $classes->count();
        $photoCounts = $photos->count();
        $videoCounts = $videos->count();

        $userCount = User::count();
        $guruCount = User::where('level', 'GURU')->count();
        $siswaCount = User::where('level', 'SISWA')->count();
        $orangtuaCount = User::where('level', 'ORANGTUA')->count();

        // Misalnya kamu juga masih punya data lain:
        // $teacherClasses = ...;
        // $photos = ...;

        return view('superadmin.beranda', compact(
            'schools',
            'schoolCounts',
            // 'classes',
            'lscounts',
            'classCounts',
            'userCount',
            'guruCount',
            'siswaCount',
            'orangtuaCount',
            'videoCounts',
            'photoCounts'
        ));
    }
}
