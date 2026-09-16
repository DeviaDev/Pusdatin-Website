<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\SopDocument;
use App\Models\Ticket;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [];
        foreach (Ticket::STATUS as $key => $label) {
            $counts[$key] = Ticket::where('status', $key)->count();
        }
        $totalTiket = Ticket::count();
        $totalPegawai = User::where('role', 'pegawai')->count();
        $totalPengumuman = Announcement::count();
        $totalSop = SopDocument::count();
        $tiketTerbaru = Ticket::with('user')->latest()->take(8)->get();

        return view('admin.dashboard', compact('counts', 'totalTiket', 'totalPegawai', 'totalPengumuman', 'totalSop', 'tiketTerbaru'));
    }
}
