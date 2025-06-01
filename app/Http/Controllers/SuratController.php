<?php

namespace App\Http\Controllers;

use App\Models\Seksi;
use App\Models\Surat;
use App\Models\User;
use App\Notifications\SuratBaruNotification;
use App\Notifications\SuratDikirimNotification;
use App\Notifications\SuratSelesaiNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surats = Surat::all();

        return view('dashboard.surat.index', compact('surats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kurirs = User::where('role', 'kurir')->get();
        $seksis = Seksi::all();

        return view('dashboard.surat.create', compact('kurirs', 'seksis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kepada' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kurir' => 'required|exists:users,id',
            'seksi' => 'required|exists:seksis,id',
        ]);

        $no_resi = 'RS' . now()->format('ymd') . Str::upper(Str::random(4));

        $surat = Surat::create([
            'no_resi' => $no_resi,
            'kepada' => $validated['kepada'],
            'alamat' => $validated['alamat'],
            'kurir_id' => $validated['kurir'],
            'seksi_id' => $validated['seksi'],
            'created_by' => auth()->id(),
        ]);

        // Kirim notifikasi ke kurir yang ditugaskan
        $kurir = User::find($validated['kurir']);
        $kurir->notify(new SuratBaruNotification($surat));

        return redirect()->route("surat.index")->with('success', 'Surat berhasil disimpan.');
    }

    public function show(string $id)
    {
        $surat = Surat::with(['kurir', 'seksi'])->findOrFail($id);
        return view('dashboard.surat.show', compact('surat'));
    }

    public function edit(string $id)
    {
        $surat = Surat::findOrFail($id);
        $kurirs = User::where('role', 'kurir')->get();
        $seksis = Seksi::all();
        return view('dashboard.surat.edit', compact('surat', 'kurirs', 'seksis'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'kepada' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kurir' => 'required|exists:users,id',
            'seksi' => 'required|exists:seksis,id',
            'status' => 'required|integer|min:0|max:3'
        ]);

        $surat = Surat::findOrFail($id);
        $surat->update([
            'kepada' => $validated['kepada'],
            'alamat' => $validated['alamat'],
            'kurir_id' => $validated['kurir'],
            'seksi_id' => $validated['seksi'],
            'status' => $validated['status'],
        ]);

        return redirect()->route("surat.index")->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $surat = Surat::findOrFail($id);
        $surat->delete();
        return redirect()->route("surat.index")->with('success', 'Surat berhasil dihapus.');
    }

    public function kirim($id)
    {
        $surat = Surat::findOrFail($id);
        $surat->status = 1;
        $surat->save();

        // Kirim notifikasi ke semua admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new SuratDikirimNotification($surat));
        }

        return redirect()->back()->with('success', 'Surat sedang dikirim.');
    }

    public function selesai(Request $request, $id)
    {
        $request->validate([
            'bukti_pengiriman' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $surat = Surat::findOrFail($id);

        if ($request->hasFile('bukti_pengiriman')) {
            $filename = $surat->no_resi . '.' . $request->file('bukti_pengiriman')->getClientOriginalExtension();
            $path = $request->file('bukti_pengiriman')->storeAs('bukti_pengiriman', $filename, 'public');
            $surat->bukti_pengiriman = $path;
        }

        $surat->status = 2;
        $surat->save();

        // Kirim notifikasi ke semua admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new SuratSelesaiNotification($surat));
        }

        return redirect()->back()->with('success', 'Pengiriman selesai.');
    }
}
