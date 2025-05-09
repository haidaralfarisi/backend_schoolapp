<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\School;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    public function index()
    {

        // $schools = School::all(); // Ambil semua sekolah tanpa filter class_id
        // $classModel = ClassModel::all(); // Ambil semua kelas
        // $videos = Video::all(); // Ambil video beserta relasi sekolah & kelasnya

        $videos = Video::with(['school', 'ClassModel'])->paginate(10); // pastikan dari DB
        $schools = School::all();
        $classModel = ClassModel::all();

        return view('superadmin.video.index', compact('schools', 'classModel', 'videos'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'school_id' => 'required|exists:schools,school_id',
            'class_id'  => 'required|exists:classes,class_id',
            'url'         => 'nullable|string',
        ]);

        // dd($request->all());

        Video::create([
            'title'       => $request->title,
            'description' => $request->description,
            'school_id'   => $request->school_id,
            'class_id'    => $request->class_id,
            'url'         => $request->url,
        ]);


        return redirect()->back()->with('success', 'Video berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
        
        // Validasi data input
        $request->validate([
            'title'       => 'required|string|max:255',
            'school_id'   => 'required|exists:schools,school_id',
            'class_id'    => 'required|exists:classes,class_id',
            'url'         => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // Cari data video berdasarkan ID
        $video = Video::findOrFail($id);

        // Update data
        $video->update([
            'title'       => $request->title,
            'school_id'   => $request->school_id,
            'class_id'    => $request->class_id,
            'url'         => $request->url,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Video berhasil diperbarui.');
    }



    public function destroy($id)
    {
        try {
            $video = Video::findOrFail($id);
            $video->delete();

            return redirect()->back()->with('success', 'Video berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus video.');
        }
    }

    // public function getClasses(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $request->validate([
    //             'school_id' => 'required|exists:schools,school_id'
    //         ]);

    //         $classes = ClassModel::where('school_id', $request->school_id)->get();

    //         return response()->json($classes);
    //     }

    //     return response()->json(['error' => 'Invalid request'], 400);
    // }
}
