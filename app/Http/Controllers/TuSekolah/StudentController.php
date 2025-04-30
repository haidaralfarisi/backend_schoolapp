<?php

namespace App\Http\Controllers\TuSekolah;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\School;
use App\Models\Student;
use App\Models\Userschool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['school', 'class'])->get();
        $userschool = Userschool::where('user_id', Auth::user()->id)->first();
        $school = School::where('school_id', $userschool->school_id)->first();
        $classes = ClassModel::where('school_id', $school->school_id)->get();

        $firstStudent = $students->first();
        $schoolClasses = $firstStudent ? ClassModel::where('school_id', $firstStudent->school_id)->get() : collect([]);

        return view('tusekolah.student.index', compact('students', 'school', 'classes'));
    }

    public function getClasses(Request $request)
    {
        if ($request->ajax()) {
            $schoolClasses = ClassModel::where('school_id', $request->school_id)->get();
            return response()->json($schoolClasses);
        }
    }


    public function store()
    {
        // Validasi data
        $validated = request()->validate([
            'student_id' => 'required',
            'nisn' => 'required',
            'fullname' => 'required',
            'username' => 'required',
            'gender' => 'required',
            'pob' => 'required',
            'dob' => 'required',
            'school_id' => 'required',
            'class_id' => 'required',
            'entry_year' => 'required',
        ]);

        // Simpan data ke database
        Student::create($validated);

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Student successfully added.');
    }

    public function update()
    {
        // Validasi data
        $validated = request()->validate([
            'name' => 'required',
            'nis' => 'required',
            'class_id' => 'required',
            'school_id' => 'required',
        ]);

        // Simpan data ke database
        Student::create($validated);

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Student successfully updated.');
    }
}
