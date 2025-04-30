<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index($school_id)
    {
        $school = School::where('school_id', $school_id)->first();
        $classes = ClassModel::where('school_id', $school_id)->get(); // Sesuaikan dengan model kelas
        $students = Student::where('school_id', $school_id)->get(); // Sesuaikan dengan model siswa

        return view('superadmin.student.index', compact('school', 'classes', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,school_id',
            'class_id' => 'required|exists:classes,class_id',
            'nisn' => 'required|string|max:15|unique:students,nisn',
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:students,username',
            'gender' => 'required|in:Male,Female',
            'pob' => 'required|string|max:255',
            'dob' => 'required|date',
            'user_id' => 'nullable',
            'entry_year' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        // Ambil data entry_year dan school_id dari request
        $entryYear = $request->entry_year;
        $schoolId = $request->school_id;

        // Cari student terakhir dengan format {entryYear}{schoolId}XXX
        $lastStudent = Student::where('student_id', 'LIKE', "$entryYear$schoolId%")
            ->orderBy('student_id', 'desc')
            ->first();

        // Ambil nomor urut terakhir dan tambahkan 1
        if ($lastStudent) {
            $lastNumber = (int) substr($lastStudent->student_id, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        // Buat student_id baru
        $student_id = $entryYear . $schoolId . $newNumber;

        // Simpan data ke database
        Student::create([
            'student_id' => $student_id,
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'nisn' => $request->nisn,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'gender' => $request->gender,
            'pob' => $request->pob,
            'dob' => $request->dob,
            'user_id' => $request->user_id ?? null,
            'entry_year' => $request->entry_year,
        ]);

        return redirect()->back()->with('success', 'Student added successfully with ID: ' . $student_id);
    }



    public function update(Request $request, $student_id)
    {
        $student = Student::where('student_id', $student_id)->firstOrFail();

        $request->validate([
            // 'student_id' => 'required|string',
            'school_id' => 'required|exists:schools,school_id',
            'class_id' => 'required|exists:classes,class_id',
            'nisn' => 'required|string|max:15|unique:students,nisn,' . $student_id . ',student_id',
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:students,username,' . $student_id . ',student_id',
            'gender' => 'required|in:Male,Female',
            'pob' => 'required|string|max:255',
            'dob' => 'required|date',
            'entry_year' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $student->update([
            // 'student_id' => $request->student_id,
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'nisn' => $request->nisn,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'gender' => $request->gender,
            'pob' => $request->pob,
            'dob' => $request->dob,
            'entry_year' => $request->entry_year,
        ]);

        return redirect()->back()->with('success', 'Student updated successfully');
    }

    public function destroy($student_id)
    {
        $student = Student::where('student_id', $student_id)->firstOrFail();

        $student->delete();

        return redirect()->back()->with('success', 'Student deleted successfully');
    }
}
