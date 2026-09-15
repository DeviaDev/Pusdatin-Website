<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'kode', 'user_id', 'kategori', 'subjek', 'detail', 'status',
        'drive_file_id', 'drive_file_link', 'local_file_path', 'sheet_row',
        'catatan_admin', 'selesai_at',
    ];

    protected $casts = ['detail' => 'array', 'selesai_at' => 'datetime'];

    public const KATEGORI = [
        'hardware'  => 'Gangguan Perangkat Keras (Hardware)',
        'software'  => 'Gangguan Perangkat Lunak (Software)',
        'jaringan'  => 'Jaringan dan Infrastruktur Internet',
        'email'     => 'Layanan Akun Email',
        'hak_akses' => 'Layanan Hak Akses',
    ];

    public const STATUS = [
        'pending'     => 'Pending',
        'diproses'    => 'Diproses',
        'izin_eselon' => 'Menunggu Izin Eselon',
        'ditolak'     => 'Ditolak',
        'selesai'     => 'Selesai',
    ];

    public const STATUS_BADGE = [
        'pending'     => 'badge-pending',
        'diproses'    => 'badge-diproses',
        'izin_eselon' => 'badge-izin',
        'ditolak'     => 'badge-ditolak',
        'selesai'     => 'badge-selesai',
    ];

    public function user() { return $this->belongsTo(User::class); }

    public function histories() { return $this->hasMany(TicketStatusHistory::class)->latest(); }

    public function kategoriLabel(): string { return self::KATEGORI[$this->kategori] ?? $this->kategori; }

    public function statusLabel(): string { return self::STATUS[$this->status] ?? $this->status; }
}
