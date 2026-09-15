<?php
namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(public Ticket $ticket, public string $catatan = '') {}

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Update Tiket ' . $this->ticket->kode . ': ' . $this->ticket->statusLabel())
            ->line('Status tiket "' . $this->ticket->subjek . '" kini: **' . $this->ticket->statusLabel() . '**')
            ->line($this->catatan ?: 'Silakan cek portal untuk detail lebih lanjut.')
            ->action('Lihat Tiket', route('portal.tiket.show', $this->ticket->id));
    }

    public function toArray($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'kode' => $this->ticket->kode,
            'status' => $this->ticket->status,
            'status_label' => $this->ticket->statusLabel(),
            'catatan' => $this->catatan,
            'pesan' => 'Tiket ' . $this->ticket->kode . ' berubah status menjadi "' . $this->ticket->statusLabel() . '"',
        ];
    }
}
