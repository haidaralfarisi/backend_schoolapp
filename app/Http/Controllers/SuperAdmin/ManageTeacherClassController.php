<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\TeacherClass;
use App\Models\User;
use Illuminate\Http\Request;

class ManageTeacherClassController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'school_id' => 'required',
            'class_id' => 'required',
        ]);

        User::findOrFail($request->user_id);
        TeacherClass::create([
            'user_id' => $request->user_id,
            'school_id' => $request->school_id,
            'class_id' => $request->class_id,
        ]);

        return redirect()->back()->with('success', 'User berhasil dikaitkan dengan sekolah.');
    }

    public function destroy($id)
    {
        $techerClass = TeacherClass::findOrFail($id);

        $techerClass->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus dari sekolah.');
    }
}
