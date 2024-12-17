<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiscellaneousList extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function miscellaneousCategory()
    {
        return $this->belongsTo(MiscellaneousCategory::class, 'miscellaneous_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function miscellaneous()
    {
        return $this->hasMany(Miscellaneous::class);
    }

    public function contents()
    {
        return $this->morphToMany(Content::class, 'listable')->withTimestamps();
    }
}
