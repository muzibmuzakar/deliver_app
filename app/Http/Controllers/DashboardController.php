<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        $kurirId = auth()->user()->id;

        $suratPerHari = Surat::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as jumlah'))
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->when(auth()->user()->role === 'kurir', function ($query) use ($kurirId) {
                return $query->where('kurir_id', $kurirId);
            })
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $labels = [];
        $data = [];

        for ($date = $startOfWeek; $date <= $endOfWeek; $date->addDay()) {
            $formatted = $date->format('Y-m-d');
            $labels[] = $date->translatedFormat('l');
            $jumlah = $suratPerHari->firstWhere('tanggal', $formatted)->jumlah ?? 0;
            $data[] = $jumlah;
        }

        return view('dashboard.index', compact('labels', 'data'));
    }
}
