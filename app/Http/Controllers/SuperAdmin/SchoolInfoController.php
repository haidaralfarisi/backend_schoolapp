<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolInfos = SchoolInfo::with('school')->get();

        $schools = School::all();

        // dd($schoolInfos);

        return view('superadmin.schoolInfo.index', compact('schoolInfos', 'schools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,school_id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('schoolInfo', 'public');
        }

        SchoolInfo::create($data);


        return redirect()->back()->with('success', 'School Info created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Cari data SchoolInfo berdasarkan ID
        $schoolInfo = SchoolInfo::findOrFail($id);

        // Validasi input
        $request->validate([
            'school_id' => 'required|exists:schools,school_id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cek jika ada gambar yang di-upload
        if ($request->hasFile('image')) {
            // Hapus file lama jika ada
            if ($schoolInfo->image && Storage::disk('public')->exists($schoolInfo->image)) {
                Storage::disk('public')->delete($schoolInfo->image);
            }

            // Simpan file gambar baru
            $schoolInfo->image = $request->file('image')->store('schoolInfo', 'public');
        }

        // Update data lainnya
        $schoolInfo->update([
            'school_id' => $request->school_id,
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'image' => $schoolInfo->image,
        ]);

        // Kembalikan response setelah berhasil update
        return redirect()->back()->with('success', 'School Info Updated successfully.');
    }


    public function destroy($id)
    {
        $schoolInfo = SchoolInfo::findOrFail($id);

        Storage::disk('public')->delete($schoolInfo->image);

        $schoolInfo->delete();

        return redirect()->back()->with('success', 'School info berhasil dihapus.');
    }
}
