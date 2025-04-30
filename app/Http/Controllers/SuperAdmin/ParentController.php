<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Student;
// use App\Http\Controllers\ParentController;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{

    public function index()
    {

        $parents = User::where('level', 'ORANGTUA')->with('students')->paginate(10);
        $students = Student::all();
        return view('superadmin.parent.index', compact('parents', 'students'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nip' => ['numeric', 'unique:users,nip'],
            'fullname' => 'required|string|max:255',
            'email' => ['email', 'unique:users,email'],
            'username' => 'nullable|string|unique:users,username',
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
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'level' => $request->level,
            'photo' => $photoPath, // Simpan path di database
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nip' => ['nullable', 'numeric', 'unique:users,nip,' . $id],
            'fullname' => 'required|string|max:255',
            'email' => 'email|max:255|unique:users,email,' . $id,
            'username' => 'nullable|string|max:255|unique:users,username,' . $id,
            'level' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'password' => 'nullable|min:6', // Boleh kosong
        ]);

        // Update field satu per satu
        $user->nip = $validated['nip'] ?? null;
        $user->fullname = $validated['fullname'];
        $user->email = $validated['email'] ?? null;
        $user->username = $validated['username'] ?? null;
        $user->level = $validated['level'];

        // Cek jika ada file foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            // Simpan foto baru
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function updateStudents(Request $request, $id)
    {
        $parent = User::where('level', 'ORANGTUA')->findOrFail($id);

        // Reset hubungan lama
        Student::where('user_id', $parent->id)->update(['user_id' => null]);

        // Assign ulang ke parent hanya siswa yang belum punya parent
        if ($request->has('student_ids')) {
            Student::whereIn('id', $request->student_ids)
                ->update(['user_id' => $parent->id]);
        }

        return redirect()->back()->with('success', 'Data anak berhasil diperbarui.');
    }


    public function assign(Request $request)
    {
        // return $request;
        // Validasi input

        // dd($request->all());
        $request->validate([
            'user_id' => 'required',
            'student_id' => 'required',
        ]);

        $student = Student::findOrFail($request->student_id);

        // Update kolom user_id di tabel students
        $student->update([
            'user_id' => $request->id,
        ]);

        return redirect()->route('superadmin.parent.index')->with('success', 'Student assigned successfully.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cek apakah user ini adalah orangtua dan masih memiliki anak
        if ($user->level === 'ORANGTUA' && $user->students()->exists()) {
            return redirect()->back()->with('error', 'User masih memiliki anak yang terhubung. Harap Hapus Data Anak terlebih dahulu.');
        }

        // Hapus foto jika ada
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        // Hapus user
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }



    public function removeStudent($parentId, $studentId)
    {
        $student = Student::where('id', $studentId)
            ->where('user_id', $parentId)
            ->firstOrFail();

        // Hapus hubungan student dengan parent
        $student->user_id = null;
        $student->save();

        return redirect()->back()->with('success', 'Siswa berhasil dihapus dari orangtua.');
    }
}







 // dd(vars: $parents);
        // Ambil semua parent
        // $parents = DB::table('users')
        //     ->where('level', 'ORANGTUA')
        //     ->get();

        // Ambil semua students yang punya user_id
        // $students = DB::table('students')
        //     ->whereIn('user_id', $parents->pluck('id'))
        //     ->get();

        // Kelompokkan student berdasarkan user_id (parent_id)
        // $parent_students = $students->groupBy('user_id');