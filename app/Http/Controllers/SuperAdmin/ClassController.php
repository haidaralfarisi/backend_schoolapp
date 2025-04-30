<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\School;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index($school_id)
    {
        $schools = School::where('school_id', $school_id)->firstOrFail();
        $classes = ClassModel::where('school_id', $school_id)->get(); // Sesuaikan dengan model kelas
    
        return view('superadmin.kelas.index', compact('schools', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|unique:classes,class_id',
            'school_id' => 'required|exists:schools,school_id',
            'class_name' => 'required|string|max:255',
            'grade' => 'required|string',
        ]);

        ClassModel::create([
            'class_id' => $request->class_id,
            'school_id' => $request->school_id,
            'class_name' => $request->class_name,
            'grade' => $request->grade,
        ]);

        return redirect()->back()->with('success', 'Class added successfully');
    }

    public function update(Request $request, $class_id)
    {
        $class = ClassModel::where('class_id', $class_id)->firstOrFail();

        $request->validate([
            'class_id' => 'required|string',
            'school_id' => 'required|exists:schools,school_id',
            'class_name' => 'required|string|max:255',
            'grade' => 'required|string',
        ]);

        $class->update([
            'class_id' => $request->class_id,
            'school_id' => $request->school_id,
            'class_name' => $request->class_name,
            'grade' => $request->grade,
        ]);

        return redirect()->back()->with('success', 'Class updated successfully');
    }

    public function destroy($class_id)
    {
        $class = ClassModel::where('class_id', $class_id)->firstOrFail();

        $class->delete();

        return redirect()->back()->with('success', 'Class deleted successfully');
    }
}
