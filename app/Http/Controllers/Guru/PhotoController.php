<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Photo;
use App\Models\School;
use App\Models\Student;
use App\Models\TeacherClass;
use App\Models\Userschool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class PhotoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userSchool = Userschool::where('user_id', $user->id)->first();

        $teacherClass = collect(); // kosongkan jika userSchool null
        $photos = collect(); // kosongkan jika userSchool null

        if ($userSchool) {
            $teacherClass = DB::table('teacher_classes')
                ->join('classes', 'teacher_classes.class_id', '=', 'classes.class_id')
                ->select('teacher_classes.*', 'classes.class_name')
                ->where('teacher_classes.user_id', $userSchool->user_id)
                ->get();

            $photos = Photo::with(['classes', 'school', 'student'])->get();
        }

        return view('guru.photo.index', compact('userSchool', 'teacherClass', 'photos'));
    }



    // public function getClasses(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $classes = ClassModel::where('school_id', $request->school_id)->get();
    //         return response()->json($classes);
    //     }
    // }

    // public function getStudents(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $students = Student::where('class_id', $request->class_id)->get();
    //         return response()->json($students);
    //     }
    // }


    public function store(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'user_id' => 'required',
            'school_id' => 'required|exists:schools,school_id',
            'class_id' => 'required|exists:classes,class_id',
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,jpg|max:2048',
            'description' => 'nullable|string',
            'photo_type'  => 'required|in:public,private',
            'location' => 'nullable|string|max:255',
        ]);

        $imagePath = $request->file('image')->store('photos', 'public');

        Photo::create([
            'title' => $request->title,
            'user_id' => $request->user_id,
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'image' => $imagePath,
            'description' => $request->description,
            'photo_type'  => $request->photo_type,
            'location' => $request->location,
        ]);

        return redirect()->back()->with('success', 'Photo berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {

        // return dd($request);
        $photo = Photo::findOrFail($id);

        $request->validate([
            'user_id' => 'required',
            'school_id' => 'required|exists:schools,school_id',
            'class_id' => 'required|exists:classes,class_id',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg|max:2048',
            'description' => 'required|string',
            'photo_type'  => 'required|in:public,private',
            'location' => 'required|string|max:255',
        ]);

        // Jika ada file baru, hapus file lama dan upload baru
        if ($request->hasFile('image')) {

            // Hapus file lama jika ada
            if ($photo->image && Storage::disk('public')->exists($photo->image)) {
                Storage::disk('public')->delete($photo->image);
            }

            // Simpan file baru
            $photo->image = $request->file('image')->store('photos', 'public');
        }

        // Update data lainnya
        $photo->update([
            'title' => $request->title,
            'user_id' => $request->user_id,
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'student_id' => $request->student_id,
            'description' => $request->description,
            'photo_type'  => $request->photo_type,
            'location' => $request->location,
            'image' => $photo->image, // <-- #review 
        ]);

        return redirect()->back()->with('success', 'Photo berhasil diperbarui!');
    }


    public function destroy($id)
    {

        $photo = Photo::findOrFail($id);

        Storage::disk('public')->delete($photo->image);

        $photo->delete();

        return redirect()->route('guru.photos.index')->with('success', 'Photo berhasil dihapus!');
    }
}
