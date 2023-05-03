<?php

namespace App\Services;

use App\Interfaces\PersonApiInterface;
use App\Models\Event;
use App\Models\Person;
use App\Models\User;
use App\Repositories\PersonRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

// TODO add interface
class EmailWriterService
{

    public function __construct(
        private PersonApiInterface $personApi,
        private PersonRepository $personRepository,
    ) {
    }

    public function makeEmail(User $user, \DateTimeImmutable $date): array
    {
        $events = $this->getEventsByDate($user, $date);

        $json = [];

        /** @var Event $event */
        foreach ($events as $event) {
            $carbonStart = new Carbon($event->start_at);
            $carbonEnd = new Carbon($event->end_at);
            $duration = $carbonStart->shortAbsoluteDiffForHumans($carbonEnd);

            // TODO naming might be better
            $eventJson = [
                'start_at' => $event->start_at->format('h:i A'),
                'end_at' => $event->end_at->format('h:i A'),
                'duration' => $duration,
                'title' => $event->title,
                'users' => [],
                'attendees' => $this->getPersons($event, $user->email)
            ];
            /** @var User $u */
            foreach ($event->users as $u) {
                $eventJson['users'][] = $u->name;
            }

            $json[] = $eventJson;
        }

        return $json;
    }

    private function getEventsByDate(User $user, \DateTimeImmutable $date): Collection
    {
        return $user->events()->whereDate('start_at', $date->format('Y-m-d'))->get();
    }

    private function getPersons(Event $event, string $excludeEmail): array
    {
        $result = [];

        /** @var Person $person */
        foreach ($event->persons as $person) {
            $result[] = [
                'first_name' => $person->first_name,
                'last_name' => $person->last_name,
                'avatar_url' => $person->avatar_url,
                'linkedin_url' => $person->linkedin_url,
                'title' => $person->title,
                'is_attending' => $person->pivot->is_attending,
                'meetings_count' => $this->personRepository->meetingCount($person),
                'met_with' => $this->personRepository->findMetWithUsersCount($person, $excludeEmail),
                'company' => [
                    'name' => $person->company->name,
                    'employees' => $person->company->employees,
                    'linkedin_url' => $person->company->linkedin_url
                ]
            ];
        }

        return $result;
    }
}
