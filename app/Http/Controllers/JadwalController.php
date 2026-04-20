<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (in_array($user->position, ['Administrator', 'Guru BK'])) {
            $jadwals = Jadwal::with('user')->paginate(10);
        } else {
            $jadwals = Jadwal::with('user')->where('user_id', $user->id)->paginate(10);
        }
        return view('jadwal.index', compact('jadwals'));
    }
}
