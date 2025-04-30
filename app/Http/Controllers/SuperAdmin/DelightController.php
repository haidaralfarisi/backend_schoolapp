<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Delight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DelightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $delights = Delight::paginate(1);

        return view('superadmin.delight.index', compact('delights'));
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf',
        ]);

        // Simpan file PDF ke storage
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('delights', 'public'); // Simpan di storage/app/public/lessonplans
        }

        // Simpan data ke database
        Delight::create([
            'title' => $request->title,
            'description' => $request->description,
            'file' => $filePath ?? null, // Simpan path file
        ]);

        return redirect()->back()->with('success', 'Delight created successfully.');
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf', // ubah jadi nullable supaya file tidak wajib di-update
        ]);

        $delight = Delight::findOrFail($id);

        $delight->title = $request->title;
        $delight->description = $request->description;


        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($delight->file && Storage::disk('public')->exists($delight->file)) {
                Storage::disk('public')->delete($delight->file);
            }

            // Simpan file baru
            $filePath = $request->file('file')->store('delights', 'public');
            $delight->file = $filePath;
        }

        // Save sekali saja
        $delight->save();

        return redirect()->back()->with('success', 'Delight updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delight = Delight::findOrFail($id);

        // Hapus file PDF jika ada
        if ($delight->file) {
            Storage::disk('public')->delete($delight->file);
        }

        $delight->delete();

        return redirect()->back()->with('success', 'Delight deleted successfully');
    }
}
