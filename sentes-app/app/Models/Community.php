<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function list()
    {
        return $this->belongsTo(CommunityList::class, 'community_list_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'users', 'author_id');
    }
}
