<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ritual extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function list()
    {
        return $this->belongsTo(RitualList::class, 'ritual_list_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'users', 'author_id');
    }
}
