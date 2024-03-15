<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'title',
        'number',
        'street',
        'city_name',
        'zip_code',
        'bis',
        'addon',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query
                ->where('title', 'like', '%' . $search . '%');
        });
    }
}
