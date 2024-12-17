<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiscellaneousCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function miscellaneousLists()
    {
        return $this->hasMany(MiscellaneousList::class, 'miscellaneous_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
