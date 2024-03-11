<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'has_payed',
        'is_organizer',
    ];

    protected $casts = [
        'has_payed' => 'boolean',
        'is_organizer' => 'boolean',
    ];

    protected $with = [
        'event',
        'user',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeOrganizers($query)
    {
        return $query->where('is_organizer', true);
    }

    public function promoteOrganizer()
    {
        $this->is_organizer = true;
        $this->save();
    }

    public function setPaymentStatus($status)
    {
        $this->has_payed = $status;
        $this->save();
    }
}
