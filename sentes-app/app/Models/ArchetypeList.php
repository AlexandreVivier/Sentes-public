<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchetypeList extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $with = ['archetypes', 'events', 'author', 'category'];

    public function archetypes()
    {
        return $this->hasMany(Archetype::class);
    }

    public function contents()
    {
        return $this->morphToMany(Content::class, 'listable')->withTimestamps();
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ArchetypeCategory::class, 'archetype_category_id'); //->withTimestamps();
    }
}
