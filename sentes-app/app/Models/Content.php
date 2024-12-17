<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function archetypeLists()
    {
        return $this->morphedByMany(ArchetypeList::class, 'listable')->withTimestamps();
    }

    public function communityLists()
    {
        return $this->morphedByMany(CommunityList::class, 'listable')->withTimestamps();
    }

    public function ritualLists()
    {
        return $this->morphedByMany(RitualList::class, 'listable')->withTimestamps();
    }

    public function backgroundLists()
    {
        return $this->morphedByMany(BackgroundList::class, 'listable')->withTimestamps();
    }

    public function miscellaneousLists()
    {
        return $this->morphedByMany(MiscellaneousList::class, 'listable')->withTimestamps();
    }
}
