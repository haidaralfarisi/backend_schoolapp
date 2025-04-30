<?php

namespace App\Http\Controllers\TuSekolah;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\School;
use App\Models\Userschool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    public function index()
    {

        $schools = School::all();
        $userSchools = Userschool::where('user_id', Auth::user()->id)->pluck('school_id');
        $data_kelas = ClassModel::orderBy('id', 'desc')
            ->whereIn('school_id', $userSchools) // Ambil semua kelas dari sekolah yang dimiliki user
            ->get()
            ->groupBy(function ($data) {
                return $data->school->school_name;
            });

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('tusekolah.class.index', compact('data_kelas', 'schools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name' => 'required|unique:classes,class_name',
            'class_id'   => 'required|unique:classes,class_id',
            'school_id'  => 'required|exists:schools,school_id', // Pastikan school_id ada di tabel schools
            'grade' => 'required',
        ]);

        ClassModel::create([
            'class_name' => $validated['class_name'],
            'class_id' => $validated['class_id'],
            'school_id'  => $validated['school_id'], // Sekarang school_id tetap string
            'grade' => $validated['grade'],

        ]);

        return redirect()->back()->with('success', 'Class successfully added.');
    }

    public function update(Request $request, $id)
    {

        // dd($request->all()); // Cek apakah data dikirim dengan benar

        // Validasi data
        $validated = $request->validate([
            'class_id' => 'required|unique:classes,class_id,' . $id,
            'class_name' => 'required|string|max:255',
            'school_id'  => 'required|exists:schools,school_id', // Perhatikan perubahan di sini
            'grade'      => 'required|string|max:10',
        ]);

        // Temukan data berdasarkan ID (karena primary key adalah id, bukan class_id)
        $class = ClassModel::findOrFail($id);

        // Update data
        $class->update([
            'class_id'   => $validated['class_id'], // Tambahkan class_id agar bisa diperbarui
            'class_name' => $validated['class_name'],
            'school_id'  => $validated['school_id'], // Sekarang berbentuk string, bukan angka
            'grade'      => $validated['grade'],
        ]);

        return redirect()->back()->with('success', 'Class updated successfully');
    }



    public function destroy($class_id)
    {
        // Cari kelas berdasarkan class_id
        $class = ClassModel::where('class_id', $class_id)->first();

        // Periksa apakah kelas ditemukan
        if (!$class) {
            return redirect()->back()->with('error', 'Class not found.');
        }

        // Hapus kelas
        $class->delete();

        return redirect()->back()->with('success', 'Class successfully deleted.');
    }
}
