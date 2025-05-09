<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use App\Models\TeacherClass;
use App\Models\Userschool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageUserSchoolController extends Controller
{
    public function index()
    {
        $user_schools = Userschool::with(['user', 'school'])
            ->whereHas('user')
            ->whereHas('school')
            ->paginate(10);

        $users = User::with('schools')->get();
        $schools = School::all();

        // Ambil semua teacher_classes dan group by user_id
        // $teacher_classes = DB::table('teacher_classes')->get()->groupBy('user_id');
        $teacher_classes = DB::table('teacher_classes')
            ->join('classes', 'teacher_classes.class_id', '=', 'classes.class_id')
            ->select('teacher_classes.*', 'classes.class_name')
            ->get()
            ->groupBy('user_id');

        // Ambil semua kelas dan group berdasarkan school_id
        $school_classes = DB::table('classes')->get()->groupBy('school_id');

        return view('superadmin.manage.manage-userschools', compact(
            'users',
            'schools',
            'user_schools',
            'teacher_classes',
            'school_classes'
        ));
    }


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'school_id' => 'required',
        ]);

        User::findOrFail($request->user_id);
        Userschool::create([
            'user_id' => $request->user_id,
            'school_id' => $request->school_id,
        ]);

        return redirect()->back()->with('success', 'User berhasil dikaitkan dengan sekolah.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'school_id' => 'required',
        ]);

        $userschool = Userschool::findOrFail($id);
        $userschool->update([
            'user_id' => $request->user_id,
            'school_id' => $request->school_id,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }


    public function destroy($id)
    {
        // Cari data relasi user-school berdasarkan ID tabel pivot
        $userSchool = Userschool::findOrFail($id);

        // Cek apakah ada kelas yang masih diampu oleh user di sekolah ini
        $teacherClasses = TeacherClass::where('user_id', $userSchool->user_id)
            ->where('school_id', $userSchool->school_id)
            ->exists();

        if ($teacherClasses) {
            return redirect()->back()->with('error', 'User tidak bisa dihapus karena masih mengampu kelas di sekolah ini.');
        }

        // Jika aman, hapus relasinya
        $userSchool->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus dari sekolah.');
    }
}
