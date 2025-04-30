<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::with('classes.students')->paginate(10);
        return view('superadmin.school.index', compact('schools'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'school_id' => 'required|unique:schools,school_id',
            'school_name' => 'required|string',
            'region' => 'nullable|string',
            'address' => 'nullable|string',
            'email' => 'sometimes|nullable|email',
        ]);

        // dd($request->all());

        School::create([
            'school_id' => $validated['school_id'],
            'school_name' => $validated['school_name'],
            'region' => $validated['region'] ?? null,
            'address' => $validated['address'] ?? null,
            'email' => $validated['email'],

        ]);

        return redirect()->back()->with('success', 'School successfully added.');
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'school_id'    => 'required|string',
            'school_name'  => 'required|string',
            'region'       => 'nullable|string',
            'address'      => 'nullable|string',
            'email'        => 'required|email',
        ]);

        $school = School::findOrFail($id);

        $school->update($validated);

        return redirect()->back()->with('success', 'School updated successfully');
    }


    public function destroy($id)
    {
        $school = School::findOrFail($id);

        $school->delete();
        
        return redirect()->back()->with('success', 'School deleted successfully.');
    }
}
