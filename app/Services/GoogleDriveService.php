<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GoogleDriveService
{
    protected $service = null;
    protected $folderId;

    public function __construct()
    {
        $this->folderId = config('services.google.drive_folder_id');
        $json = config('services.google.service_account_json');
        if (! $json || ! Storage::disk('local')->exists(str_replace('storage/app/', '', $json))) {
            return; // fallback mode: simpan lokal
        }
        try {
            $client = new \Google\Client();
            $client->setAuthConfig(storage_path('app/' . str_replace('storage/app/', '', $json)));
            $client->addScope(\Google\Service\Drive::DRIVE_FILE);
            $this->service = new \Google\Service\Drive($client);
        } catch (\Throwable $e) {
            Log::warning('Google Drive tidak tersedia: ' . $e->getMessage());
            $this->service = null;
        }
    }

    public function isAvailable(): bool { return $this->service !== null; }

    /**
     * Upload file. Return array [file_id, web_link, local_path (fallback)].
     */
    public function upload(UploadedFile $file, string $ticketKode): array
    {
        if ($this->isAvailable()) {
            $metadata = new \Google\Service\Drive\DriveFile([
                'name' => $ticketKode . '_' . time() . '_' . $file->getClientOriginalName(),
                'parents' => $this->folderId ? [$this->folderId] : [],
            ]);
            $content = file_get_contents($file->getRealPath());
            $created = $this->service->files->create($metadata, [
                'data' => $content,
                'mimeType' => $file->getMimeType(),
                'uploadType' => 'multipart',
                'fields' => 'id,webViewLink',
            ]);
            // jadikan bisa dilihat siapa pun yang punya link
            $this->service->getClient()->setUseBatch(true);
            $batch = $this->service->createBatch();
            $permission = new \Google\Service\Drive\Permission(['type' => 'anyone', 'role' => 'viewer']);
            $batch->add($this->service->permissions->create($created->id, $permission, ['fields' => 'id']), 'perm');
            $batch->execute();
            $this->service->getClient()->setUseBatch(false);

            return ['file_id' => $created->id, 'link' => $created->webViewLink, 'local_path' => null];
        }

        // Fallback: simpan lokal
        $path = $file->storeAs('tickets/' . $ticketKode, $file->getClientOriginalName(), 'local');
        return ['file_id' => null, 'link' => null, 'local_path' => $path];
    }
}
