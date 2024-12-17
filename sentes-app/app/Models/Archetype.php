<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archetype extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $with = ['list', 'author'];

    public function list()
    {
        return $this->belongsTo(ArchetypeList::class, 'archetype_list_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'users', 'author_id');
    }
}
