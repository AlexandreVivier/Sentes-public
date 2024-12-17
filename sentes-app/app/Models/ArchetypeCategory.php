<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchetypeCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $with = ['author', 'archetypeLists'];


    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function archetypeLists()
    {
        return $this->hasMany(ArchetypeList::class, 'archetype_category_id');
    }

    // public function scopeByCategory
}
