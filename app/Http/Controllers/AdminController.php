<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('dashboard.admin');
    }

    public function jurnal(Request $request)
    {
        $query = \App\Models\JurnalMengajar::with('user');
        
        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        if ($request->guru_id) {
            $query->where('user_id', $request->guru_id);
        }
        
        $jurnals = $query->orderBy('tanggal', 'desc')->get();
        $gurus = \App\Models\User::where('position', 'like', '%Guru%')->get();
        
        return view('admin.jurnal', compact('jurnals', 'gurus'));
    }

    public function mapelIndex()
    {
        $mapels = \App\Models\Mapel::orderBy('nama_mapel', 'asc')->get();
        return view('admin.mapel.index', compact('mapels'));
    }

    public function mapelStore(Request $request)
    {
        $request->validate(['nama_mapel' => 'required|unique:mapels,nama_mapel']);
        \App\Models\Mapel::create($request->all());
        return back()->with('success', 'Mata Pelajaran berhasil ditambahkan');
    }

    public function mapelDestroy($id)
    {
        \App\Models\Mapel::destroy($id);
        return back()->with('success', 'Mata Pelajaran berhasil dihapus');
    }

    public function passwordIndex()
    {
        $users = \App\Models\User::orderBy('fullname', 'asc')->get();
        return view('admin.password.index', compact('users'));
    }

    public function passwordReset(Request $request)
    {
        $user = \App\Models\User::findOrFail($request->user_id);
        $user->update(['password' => bcrypt($request->password)]);
        return back()->with('success', "Password untuk {$user->fullname} berhasil diupdate");
    }
}
