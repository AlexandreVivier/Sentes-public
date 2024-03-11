<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'author_id',
        'location_id',
        'price',
        'image_path',
        'max_attendees',
        'file_path',
        'server_link',
        'tickets_link',
        'is_cancelled',
    ];

    protected $with = [
        'location',
        'author',
    ];


    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class);
    }

    public function organizers()
    {
        return $this->hasMany(Attendee::class)->where('is_organizer', true);
    }

    public function formatDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function cancel()
    {
        $this->update(['is_cancelled' => true]);
    }

    public function uncancel()
    {
        $this->update(['is_cancelled' => false]);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query
                ->where('title', 'like', '%' . $search . '%');
        });
    }
}
