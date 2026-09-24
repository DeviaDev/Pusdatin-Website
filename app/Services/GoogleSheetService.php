<?php
namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GoogleSheetService
{
    protected $sheets = null;
    protected $sheetId;
    protected $sheetName = 'Tiket';

    public function __construct()
    {
        $this->sheetId = config('services.google.sheet_id');
        $json = config('services.google.service_account_json');
        if (! $this->sheetId || ! $json || ! Storage::disk('local')->exists(str_replace('storage/app/', '', $json))) {
            return; 
        }
        try {
            $client = new \Google\Client();
            $client->setAuthConfig(storage_path('app/' . str_replace('storage/app/', '', $json)));
            $client->addScope(\Google\Service\Sheets::SPREADSHEETS);
            $this->sheets = new \Google\Service\Sheets($client);
        } catch (\Throwable $e) {
            Log::warning('Google Sheets tidak tersedia: ' . $e->getMessage());
            $this->sheets = null;
        }
    }

    public function isAvailable(): bool { return $this->sheets !== null; }

    public function appendTicket(Ticket $ticket): ?int
    {
        if (! $this->isAvailable()) return null;

        $detail = collect($ticket->detail)->map(fn ($v, $k) => $k . ': ' . (is_array($v) ? implode(', ', $v) : $v))->implode(' | ');

        $row = [
            $ticket->kode,
            $ticket->created_at->format('d/m/Y H:i'),
            $ticket->user->nama,
            $ticket->user->nip,
            $ticket->user->unit_kerja,
            $ticket->kategoriLabel(),
            $ticket->subjek,
            $detail,
            $ticket->drive_file_link ?? ($ticket->local_file_path ? 'local:' . $ticket->local_file_path : '-'),
            $ticket->statusLabel(),
            '',
        ];

        try {
            $body = new \Google\Service\Sheets\ValueRange(['values' => [$row]]);
            $result = $this->sheets->spreadsheets_values->append(
                $this->sheetId, $this->sheetName . '!A1', $body, ['valueInputOption' => 'USER_ENTERED']
            );
            $updates = $result->getUpdates();
            return $updates ? $updates->getUpdatedRange() : null;
        } catch (\Throwable $e) {
            Log::error('Gagal append ke Sheets: ' . $e->getMessage());
            return null;
        }
    }

    public function updateStatus(Ticket $ticket): void
    {
        if (! $this->isAvailable() || ! $ticket->sheet_row) return;
        try {
            $body = new \Google\Service\Sheets\ValueRange(['values' => [[$ticket->statusLabel(), $ticket->catatan_admin ?? '']]]);
            $this->sheets->spreadsheets_values->update(
                $this->sheetId, $this->sheetName . '!J' . $ticket->sheet_row, $body, ['valueInputOption' => 'USER_ENTERED']
            );
        } catch (\Throwable $e) {
            Log::error('Gagal update status di Sheets: ' . $e->getMessage());
        }
    }
}
