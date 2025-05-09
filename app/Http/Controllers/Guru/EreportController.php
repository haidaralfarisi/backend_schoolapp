<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Eraport;
use App\Models\Ereport;
use App\Models\Student;
use App\Models\TahunAjaran;
use App\Models\TeacherClass;
use App\Models\Userschool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EreportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        # get data TeacherClass
        $teacherClass = TeacherClass::where('user_id', $user->id)->first();

        # get data student
        $students = Student::where([
            'school_id' => $teacherClass->school_id,
            'class_id' => $teacherClass->class_id
        ])->get();

        # get data reports
        $ereports = Ereport::with('user')->get(); // Menggunakan with untuk memuat relasi user

        $tahunAjarans = TahunAjaran::all();

        return view('guru.eraport.index', compact('ereports', 'user', 'teacherClass', 'students', 'tahunAjarans'));
    }

    public function getStudent(Request $request)
    {
        $search = $request->get('search');
        $schoolId = $request->get('school_id');  // Ambil school_id dari request
        $classId = $request->get('class_id');    // Ambil class_id dari request

        $students = Student::query();

        // Filter berdasarkan school_id dan class_id
        if ($schoolId) {
            $students->where('school_id', $schoolId);
        }

        if ($classId) {
            $students->where('class_id', $classId);
        }

        // Filter berdasarkan search term
        if ($search) {
            $students->where('fullname', 'like', "%{$search}%");
        }

        // Ambil hasil terbatas 50 siswa
        $results = $students->limit(50)->get()->map(function ($student) {
            return [
                'id' => $student->id,
                'text' => $student->fullname,  // Menampilkan fullname siswa
            ];
        });

        return response()->json(['results' => $results]);
    }




    public function store(Request $request)
    {

        $request->validate([
            'school_id' => 'required|string',
            'class_id' => 'required|string',
            'student_id' => 'required|string',
            'user_id' => 'required|string',
            'report_file' => 'required|file|mimes:pdf|max:10240', // max 10 MB
            'tahun_ajaran_id' => 'required|string',
        ]);

        if ($request->hasFile('report_file')) {
            $file = $request->file('report_file');
            $path = $file->store('ereports', 'public'); // Simpan di storage/app/public/ereport
        }

        // Simpan data ke database
        Ereport::create([
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'student_id' => $request->student_id,
            'user_id' => $request->user_id,
            'report_file' => $path,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
        ]);

        return redirect()->back()->with('success', 'Ereport berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|string',
            'tahun_ajaran_id' => 'required|string',
            'report_file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $ereport = Ereport::findOrFail($id);

        // Jika ada file baru diupload
        if ($request->hasFile('report_file')) {
            // Hapus file lama jika ada
            if ($ereport->report_file && Storage::disk('public')->exists($ereport->report_file)) {
                Storage::disk('public')->delete($ereport->report_file);
            }

            // Simpan file baru
            $file = $request->file('report_file');
            $path = $file->store('ereports', 'public');
            $ereport->report_file = $path;
        }

        // Update field lainnya
        $ereport->student_id = $request->student_id;
        $ereport->tahun_ajaran_id = $request->tahun_ajaran_id;

        $ereport->save();

        return redirect()->back()->with('success', 'Ereport berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $ereport = Ereport::findOrFail($id);

        // Hapus file dari storage jika ada
        if ($ereport->report_file && Storage::disk('public')->exists($ereport->report_file)) {
            Storage::disk('public')->delete($ereport->report_file);
        }

        // Hapus data dari database
        $ereport->delete();

        return redirect()->back()->with('success', 'Ereport berhasil dihapus!');
    }
}
