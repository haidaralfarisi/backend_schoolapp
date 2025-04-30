<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\SubPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubPhotoController extends Controller
{
    public function index($id)
    {
        $photo = Photo::find($id);
        $subphoto = SubPhoto::where('photo_id', $id)->get();
        return view('guru.photo.subphoto', [
            'photo' => $photo,
            'subphoto' => $subphoto,
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'photo_id' => 'required|exists:photos,id',
            'images.*' => 'required|image|mimes:jpg,jpeg'
        ]);

        $photo = Photo::findOrFail($request->photo_id);
        $imageData = [];
        foreach ($request->file('images') as $key => $file) {
            $filename = $key . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('subphoto', $filename, 'public'); // simpan dengan nama custom
            $imageData[] = [
                'photo_id' => $photo->id,
                'image' => $filename,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        SubPhoto::insert($imageData);

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }

    public function destroy($id)
    {
        $subphoto = SubPhoto::findOrFail($id);

        Storage::disk('public')->delete('subphoto/' . $subphoto->image);


        $subphoto->delete();

        return redirect()->back()->with('success', 'Photo berhasil dihapus!');
    }
}
