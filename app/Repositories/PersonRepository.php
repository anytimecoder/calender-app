<?php

namespace App\Repositories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PersonRepository implements RepositoryInterface
{
    public function findAll(): Collection
    {
        return Person::all();
    }

    public function findById(int $id): Model
    {
        return Person::query()->findOrFail($id);
    }

    public function meetingCount(Person $person): int
    {
        return $person->events()->count();
    }

    public function findMetWithUsersCount(Person $person, string $excludeEmail): Collection
    {
        return $person
            ->events()
            ->join('user_events', 'user_events.event_id', '=', 'events.id')
            ->join('users', 'user_events.user_id', '=', 'users.id')
            ->where('users.email', '<>', $excludeEmail)
            ->groupBy('users.name')
            ->selectRaw('count(*) as total, users.name as user')
            ->get(['total', 'user'])
            ;
    }
}
