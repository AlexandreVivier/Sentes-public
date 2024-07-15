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

    // protected $fillable = [
    //     'title',
    //     'description',
    //     'start_date',
    //     'end_date',
    //     'location_id',
    //     'price',
    //     'image_path',
    //     'max_attendees',
    //     'file_path',
    //     'server_link',
    //     'tickets_link',
    //     'is_cancelled',
    //     'photos_link',
    //     'video_link',
    //     'retex_form_link',
    //     'retex_document_path',
    // ];

    protected $guarded = [];

    protected $with = [
        'location',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class, 'event_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'attendees', 'event_id', 'user_id');
    }

    public function getAttendeesCount()
    {
        return $this->attendees()->where('is_subscribed', true)->count();
    }

    public function organizers()
    {
        return $this->attendees()->where('is_organizer', true)->where('is_subscribed', true);
    }

    public function getOrganizersCount()
    {
        return $this->organizers()->count();
    }

    public function getOrganizersLogin()
    {
        return $this->organizers->map(function ($organizer) {
            return $organizer->user->login;
        })->implode(', ');
    }

    public function getOrganizerLogin($organizer)
    {
        return $organizer->user->login;
    }

    public function checkIfAuthIsOrganizer()
    {
        return $this->organizers()->where('user_id', auth()->id())->exists();
    }

    public function getNonOrganizersAttendeesLogin()
    {
        return $this->attendees()->where('is_subscribed', true)->where('is_organizer', false)->get()->map(function ($attendee) {
            return $attendee->user->login;
        })->implode(', ');
    }

    public function getNonOrganizersInfosInArray()
    {
        return $this->attendees()->where('is_subscribed', true)->where('is_organizer', false)->get()->map(function ($attendee) {
            return [
                'login' => $attendee->user->login,
                'id' => $attendee->user->id,
                'has_paid' => $attendee->has_paid
            ];
        });
    }

    public function getSubscribedAttendeesInfosInArray()
    {
        return $this->attendees()->where('is_subscribed', true)->get()->map(function ($attendee) {
            return [
                'login' => $attendee->user->login,
                'first_name' => $attendee->user->first_name,
                'last_name' => $attendee->user->last_name,
                'diet_restrictions' => $attendee->user->diet_restrictions,
                'allergies' => $attendee->user->allergies,
                'red_flag_people' => $attendee->user->red_flag_people,
                'medical_conditions' => $attendee->user->medical_conditions,
                'emergency_contact_name' => $attendee->user->emergency_contact_name,
                'emergency_contact_phone_number' => $attendee->user->emergency_contact_phone_number,
                'phone_number' => $attendee->user->phone_number,
                'trigger_warnings' => $attendee->user->trigger_warnings,
                'pronouns' => $attendee->user->pronouns,
                'first_aid_qualifications' => $attendee->user->first_aid_qualifications,
                'id' => $attendee->user->id,
                'has_paid' => $attendee->has_paid,
                'is_organizer' => $attendee->is_organizer,
                'in_choir' => $attendee->in_choir,
            ];
        });
    }

    public function getUnsubscribedAttendeesInfosInArray()
    {
        return $this->attendees()->where('is_subscribed', false)->get()->map(function ($attendee) {
            return [
                'login' => $attendee->user->login,
                'first_name' => $attendee->user->first_name,
                'last_name' => $attendee->user->last_name,
                'diet_restrictions' => $attendee->user->diet_restrictions,
                'allergies' => $attendee->user->allergies,
                'red_flag_people' => $attendee->user->red_flag_people,
                'medical_conditions' => $attendee->user->medical_conditions,
                'emergency_contact_name' => $attendee->user->emergency_contact_name,
                'emergency_contact_phone_number' => $attendee->user->emergency_contact_phone_number,
                'phone_number' => $attendee->user->phone_number,
                'trigger_warnings' => $attendee->user->trigger_warnings,
                'pronouns' => $attendee->user->pronouns,
                'first_aid_qualifications' => $attendee->user->first_aid_qualifications,
                'id' => $attendee->user->id,
                'has_paid' => $attendee->has_paid,
                'is_organizer' => $attendee->is_organizer,
                'in_choir' => $attendee->in_choir,
            ];
        });
    }

    public function getUnsubscribedAttendeesCount()
    {
        return $this->attendees()->where('is_subscribed', false)->count();
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
