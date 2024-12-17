<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miscellaneous extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function miscellaneousList()
    {
        return $this->belongsTo(MiscellaneousList::class, 'miscellaneous_list_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'users', 'author_id');
    }
}
