<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RitualList extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function rituals()
    {
        return $this->hasMany(Ritual::class);
    }

    public function contents()
    {
        return $this->morphToMany(Content::class, 'listable')->withTimestamps();
    }
}
