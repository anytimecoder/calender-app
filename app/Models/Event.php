<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'title',
        'start_at',
        'end_at',
        'changed_at'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'person_events')->withPivot('is_attending');
    }

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'user_events');
    }
}
