<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property mixed $start_at
 * @property mixed $end_at
 * @property string $title
 * @property Collection<Person> $persons
 * @property Collection<User> $users
 */
class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'calendar_event_id',
        'title',
        'start_at',
        'end_at',
        'changed_at'
    ];

    protected $hidden = ['pivot'];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'person_events')->withPivot('is_attending');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_events');
    }
}
