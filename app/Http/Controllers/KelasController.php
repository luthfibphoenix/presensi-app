<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelases = Kelas::orderBy('nama_kelas', 'asc')->get();
        return view('kelas.index', compact('kelases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'kode_kelas' => 'required|unique:kelas,kode_kelas',
        ]);

        Kelas::create($request->all());
        return back()->with('success', 'Kelas berhasil ditambahkan');
    }

    public function destroy($id)
    {
        Kelas::destroy($id);
        return back()->with('success', 'Kelas berhasil dihapus');
    }
}
