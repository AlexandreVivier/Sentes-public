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

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUser()
    {
        return $this->user()->get();
    }

    public function getUserLogin()
    {
        return $this->user->login;
    }

    public function getEvent()
    {
        return $this->event()->get();
    }

    public function getEventTitle()
    {
        return $this->event->title;
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
