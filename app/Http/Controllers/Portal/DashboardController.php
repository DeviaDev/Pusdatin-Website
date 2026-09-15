<?php
namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tiketCount = $user->tickets()->count();
        $pengumuman = Announcement::published()->take(5)->get();
        $tiketSaya = $user->tickets()->latest()->take(5)->get();
        $notifikasi = $user->unreadNotifications()->latest()->take(5)->get();

        return view('portal.dashboard', compact('tiketCount', 'pengumuman', 'tiketSaya', 'notifikasi'));
    }

    public function readAllNotifications()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
