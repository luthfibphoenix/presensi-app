<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
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
}
