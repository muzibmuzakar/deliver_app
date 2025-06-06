<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenugasanController extends Controller
{
    public function index()
    {
        $surats = Surat::where('kurir_id', Auth::id())->get();

        return view('dashboard.penugasan.index', compact('surats'));
    }

    public function show(string $id)
    {
        $surat = Surat::with(['kurir', 'seksi'])->findOrFail($id);
        return view('dashboard.penugasan.detail', compact('surat'));
    }
}
