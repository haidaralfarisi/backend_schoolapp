<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        // Ambil semua data Tahun Ajaran beserta data relasi ereport-nya
        $tahunAjarans = TahunAjaran::with('ereport')->get();

        // Kirim ke view
        return view('superadmin.tahunAjaran.index', compact('tahunAjarans'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'dari_tahun' => 'required|digits:4|integer|min:2000|max:2100',
            'ke_tahun' => 'required|digits:4|integer|min:2000|max:2100|gte:dari_tahun',
        ]);

        // Ambil input tahun
        $dariTahun = $request->dari_tahun;
        $keTahun = $request->ke_tahun;

        // Format otomatis
        $tahunAjaranId = 'TA' . $dariTahun . $keTahun;
        $title = 'Tahun Ajaran ' . $dariTahun . ' - ' . $keTahun;

        // Simpan ke database
        TahunAjaran::create([
            'tahun_ajaran_id' => $tahunAjaranId,
            'title' => $title,
            // Tambahkan kolom lain jika perlu, misalnya 'ereport_id' => $request->ereport_id
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Tahun Ajaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'dari_tahun' => 'required|digits:4|integer|min:2000|max:2100',
            'ke_tahun' => 'required|digits:4|integer|min:2000|max:2100|gte:dari_tahun',
        ]);

        // Ambil input tahun
        $dariTahun = $request->dari_tahun;
        $keTahun = $request->ke_tahun;

        // Format otomatis
        $tahunAjaranId = 'TA' . $dariTahun . $keTahun;
        $title = 'Tahun Ajaran ' . $dariTahun . ' - ' . $keTahun;

        // Update data di database
        TahunAjaran::where('id', $id)->update([
            'tahun_ajaran_id' => $tahunAjaranId,
            'title' => $title,
            // Tambahkan kolom lain jika perlu, misalnya 'ereport_id' => $request->ereport_id
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Tahun Ajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->delete();

        return redirect()->back()->with('success', 'Tahun Ajaran berhasil dihapus.');
    }
}
