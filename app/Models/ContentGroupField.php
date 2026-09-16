<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentGroupField extends Model
{
    protected $fillable = ['content_group_id', 'key', 'label', 'type', 'urutan'];

    public function group() { return $this->belongsTo(ContentGroup::class); }
}