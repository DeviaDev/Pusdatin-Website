<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['judul', 'foto', 'isi', 'kategori', 'is_published', 'published_at'];

    protected $casts = ['is_published' => 'boolean', 'published_at' => 'datetime'];

    public function scopePublished($query)
    
    {
        return $query->where('is_published', true)->where('published_at', '<=', now())->latest('published_at');
    }
}
