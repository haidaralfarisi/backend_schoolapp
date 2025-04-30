<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\LessonPlan;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class LessonPlanController extends Controller
{
    public function index($class_id)
    {
        $lessonplans = LessonPlan::with('classes')->where('class_id', $class_id)->get();
        $class = ClassModel::where('class_id', $class_id)->first(); // ambil data class
        $school = School::where('school_id', $class->school_id)->first(); // ambil data school
        $users = User::all();
        $classes = ClassModel::all();

        return view('guru.lessonplan.index', compact('lessonplans', 'class', 'users', 'school', 'classes'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'school_id' => 'required|exists:schools,school_id',
            'class_id' => 'required|exists:classes,class_id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'desc' => 'required|string|max:255',
            'file_pdf' => 'required|file|mimes:pdf',
        ]);

        // Simpan file PDF ke storage
        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $filePath = $file->store('lesson_plans', 'public'); // Simpan di storage/app/public/lessonplans
        }

        // Simpan data ke database
        LessonPlan::create([
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'user_id' => $request->user_id,
            'title' => $request->title,
            'desc' => $request->desc,
            'file_pdf' => $filePath ?? null, // Simpan path file
        ]);

        return redirect()->back()->with('success', 'Lesson Plan created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,school_id',
            'class_id' => 'required|exists:classes,class_id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'desc' => 'required|string|max:255',
            'file_pdf' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $lessonPlan = LessonPlan::findOrFail($id);

        $lessonPlan->update([
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'user_id' => $request->user_id,
            'title' => $request->title,
            'desc' => $request->desc,
        ]);


        if ($request->hasFile('file_pdf')) {
            // Hapus file lama jika ada
            if ($lessonPlan->file_pdf) {
                Storage::disk('public')->delete($lessonPlan->file_pdf);
            }

            // Simpan file baru
            $filePath = $request->file('file_pdf')->store('lesson_plans', 'public');
            $lessonPlan->update(['file_pdf' => $filePath]);
        }

        return redirect()->back()->with('success', 'Lesson Plan updated successfully');
    }



    public function destroy($id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);

        // Hapus file PDF jika ada
        if ($lessonPlan->file_pdf && Storage::disk('public')->exists($lessonPlan->file_pdf)) {
            Storage::disk('public')->delete($lessonPlan->file_pdf);
        }

        $lessonPlan->delete();

        return redirect()->back()->with('success', 'Lesson Plan deleted successfully');
    }
}
