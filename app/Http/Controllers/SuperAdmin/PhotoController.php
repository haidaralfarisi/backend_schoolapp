<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentNote;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::with(['classes', 'school', 'student'])->paginate(1);

        $schools = School::all();
        $classes = ClassModel::all();
        $students = Student::all();
        // dd($photos);
        return view('superadmin.photo.index', compact('photos', 'schools', 'classes', 'students'));
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
            'school_id' => 'required|exists:schools,school_id',
            'class_id' => 'required|exists:classes,class_id',
            'student_id' => 'required|exists:students,student_id',
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'photo_type'  => 'required|in:public,private',
            'location' => 'nullable|string|max:255',
        ]);

        $imagePath = $request->file('image')->store('photos', 'public');

        Photo::create([
            'title' => $request->title,
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'student_id' => $request->student_id,
            'image' => $imagePath,
            'description' => $request->description,
            'photo_type'  => $request->photo_type,
            'location' => $request->location,
        ]);

        return redirect()->back()->with('success', 'Photo berhasil ditambahkan!');
    }

    public function update(Request $request, Photo $photo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'school_id' => 'required|exists:schools,id',
            'class_id' => 'required|exists:school_classes,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($photo->image);
            $imagePath = $request->file('image')->store('photos', 'public');
            $photo->update(['image' => $imagePath]);
        }

        $photo->update([
            'title' => $request->title,
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'description' => $request->description,
        ]);

        return redirect()->route('photos.index')->with('success', 'Photo berhasil diperbarui!');
    }

    public function destroy(Photo $photo)
    {
        Storage::disk('public')->delete($photo->image);
        $photo->delete();
        return redirect()->route('photos.index')->with('success', 'Photo berhasil dihapus!');
    }
}
