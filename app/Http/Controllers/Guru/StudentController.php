<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index($id)
    {
        $students = Student::where('class_id', $id)->get();
        return view('guru.student.index', compact('students'));
    }
}
