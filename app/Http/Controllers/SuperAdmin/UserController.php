<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::where('level', '!=', 'ORANGTUA')->paginate(10); // Ambil semua user kecuali level orangtua
        
        return view('superadmin.user.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => ['numeric', 'unique:users,nip'],
            'fullname' => 'required|string|max:255',
            'email' => ['email', 'unique:users,email'],
            'password' => 'required|min:6',
            'level' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        // Default nilai photo
        $photoPath = null;

        // Jika ada file yang diunggah
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public'); // Simpan di storage/public/photos
        }

        // Simpan data ke database
        User::create([
            'nip' => $request->nip,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level,
            'photo' => $photoPath, // Simpan path di database
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'level' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'password' => 'nullable|min:6', // Password opsional
        ]);

        // Update data user
        $user->fullname = $validatedData['fullname'];
        $user->email = $validatedData['email'];
        $user->level = $validatedData['level'];

        // Jika ada foto baru diunggah
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            // Simpan foto baru
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
        }

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Hapus foto jika ada
        if ($user->photo) {
            Storage::delete('public/' . $user->photo); // Hapus file dari storage
        }
        // Hapus user dari database
        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
