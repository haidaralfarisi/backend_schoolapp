<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    public function index()
    {
        $notes = StudentNote::with(['school', 'class', 'student'])->get();

        $schools = School::all();
        $classes = ClassModel::all();
        $students = Student::all();

        return view('guru.note.index', compact('notes', 'schools', 'classes', 'students'));
        // return view('notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'class_id' => 'required|exists:school_classes,id',
            'student_id' => 'required|exists:students,id',
            'note' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('notes', 'public');
        }

        StudentNote::create([
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
            'student_id' => $request->student_id,
            'note' => $request->note,
            'image' => $imagePath,
        ]);

        return redirect()->route('guru.notes.index')->with('success', 'Note added successfully.');
    }
    public function update(Request $request, StudentNote $note)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'class_id' => 'required|exists:school_classes,id',
            'student_id' => 'required|exists:students,id',
            'note' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($note->image) {
                Storage::disk('public')->delete($note->image);
            }
            $note->image = $request->file('image')->store('notes', 'public');
        }

        $note->update($request->except('image'));

        return redirect()->route('guru.notes.index')->with('success', 'Note updated successfully.');
    }

    public function destroy(StudentNote $note)
    {
        if ($note->image) {
            Storage::disk('public')->delete($note->image);
        }
        $note->delete();

        return redirect()->route('guru.notes.index')->with('success', 'Note deleted successfully.');
    }
}
