<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'event_id',
    //     'user_id',
    //     'has_paid',
    //     'is_organizer',
    //     'is_subscribed'
    // ];

    protected $guarded = [];

    protected $casts = [
        'has_paid' => 'boolean',
        'is_organizer' => 'boolean',
        'is_subscribed' => 'boolean'
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

    public function getPaymentStatus()
    {
        return $this->has_paid;
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

    public function setPaymentStatus(int $status)
    {
        $this->has_paid = $status;
        $this->save();
    }

    public function unsubscribe()
    {
        $this->is_subscribed = false;
        $this->save();
    }

    public function resubscribe()
    {
        $this->is_subscribed = true;
        $this->save();
    }
}
