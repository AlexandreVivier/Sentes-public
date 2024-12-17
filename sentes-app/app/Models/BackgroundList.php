<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackgroundList extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function backgrounds()
    {
        return $this->hasMany(Background::class);
    }

    public function contents()
    {
        return $this->morphToMany(Content::class, 'listable')->withTimestamps();
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
