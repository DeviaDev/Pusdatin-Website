<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentGroup extends Model
{
    protected $fillable = ['slug', 'label', 'urutan'];

    public function fields()
    {
        return $this->hasMany(ContentGroupField::class)->orderBy('urutan');
        
    }

    public function getRouteKeyName() { return 'slug'; }
}