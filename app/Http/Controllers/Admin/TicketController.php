<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketStatusHistory;
use App\Models\User;
use App\Notifications\TicketStatusUpdated;
use App\Services\GoogleSheetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $tiket = Ticket::with('user')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [];
        foreach (Ticket::STATUS as $key => $label) {
            $counts[$key] = Ticket::where('status', $key)->count();
        }
        return view('admin.tiket.index', compact('tiket', 'counts', 'status'));
    }

    public function show(Ticket $tiket)
    {
        $tiket->load(['user', 'histories.changer']);
        return view('admin.tiket.show', compact('tiket'));
    }

    public function updateStatus(Request $request, Ticket $tiket)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,izin_eselon,ditolak,selesai',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $tiket->status;
        $tiket->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan,
            'selesai_at' => $request->status === 'selesai' ? now() : null,
        ]);

        TicketStatusHistory::create([
            'ticket_id' => $tiket->id,
            'status' => $request->status,
            'catatan' => $request->catatan,
            'changed_by' => Auth::id(),
        ]);

        app(GoogleSheetService::class)->updateStatus($tiket->fresh());

        if ($oldStatus !== $request->status) {
            $tiket->user->notify(new TicketStatusUpdated($tiket->fresh(), $request->catatan ?? ''));
        }

        return back()->with('success', 'Status tiket ' . $tiket->kode . ' diperbarui menjadi "' . $tiket->statusLabel() . '".');
    }
}
