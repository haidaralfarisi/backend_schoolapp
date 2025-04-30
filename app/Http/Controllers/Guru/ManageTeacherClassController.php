<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\School;
use App\Models\TeacherClass;
use App\Models\Userschool;
use Illuminate\Http\Request;

class ManageTeacherClassController extends Controller
{
    public function index()
    {
        $users = User::with('students')->get();
        $students = Student::all(); // Ambil semua sekolah jika diperlukan
        $teacher_classes = TeacherClass::all();

        return view('guru.manage.manage-teachersclasses', compact('users', 'teacher_classes','schools'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'school_id' => 'required',
        ]);

        $user = User::findOrFail($request->user_id);
        Userschool::create([
            'user_id' => $request->user_id,
            'school_id' => $request->school_id,
        ]);
        // $user->schools()->syncWithoutDetaching([$request->school_id]);

        return redirect()->back()->with('success', 'User berhasil dikaitkan dengan sekolah.');
    }

    public function destroy($userId, $schoolId)
    {
        $user = User::findOrFail($userId);
        $user->schools()->detach($schoolId);

        return redirect()->back()->with('success', 'User berhasil dihapus dari sekolah.');
    }
}
