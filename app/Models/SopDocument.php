<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SopDocument extends Model
{
    protected $fillable = [
    'kode',
    'nama',
    'klasifikasi',
    'deskripsi',
    'file_path',
    'file_name',
    'is_active',
    'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_active' => 'boolean',
    ];
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('kode');
    }
}
