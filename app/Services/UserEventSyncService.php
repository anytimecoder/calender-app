<?php

namespace App\Services;

use App\Data\EventDTO;
use App\Data\PaginatedEventDTO;
use App\Interfaces\CalendarApiInterface;
use App\Interfaces\PersonApiInterface;
use App\Models\Company;
use App\Models\Event;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\Log;

// TODO add interface
class UserEventSyncService
{

    public function __construct(
        private CalendarApiInterface $calendarApiService,
        private PersonApiInterface $personApi,
    ) {
    }

    public function sync(User $user): void
    {
        try {
            $this->checkAndUpdateEvents($user);
        } catch (\Exception $exception) {
            echo('ERROR: ' . $exception->getMessage());
            Log::error($exception->getMessage(), [
                'user' => $user->id,
            ]);
        }

    }

    private function checkAndUpdateEvents(User $user, int $page = 1): void
    {
        $synced = false;
        $paginatedEvents = $this->calendarApiService->getEvents($user->calendar_api_token, $page);
        /** @var PaginatedEventDTO $events */
        $events = $paginatedEvents->data;
        foreach ($events as $event) {
            if (!$this->isEventPersisted($user, $event)) {
                $this->updateOrCreateEvent($user, $event);
            } else {
                $synced = true;
                break;
            }
        }

        if ($synced) {
            return;
        }
        $moreResults = $paginatedEvents->current_page * $paginatedEvents->per_page < $paginatedEvents->total;
        if ($moreResults) {
            // iterate recursively
            $this->checkAndUpdateEvents($user, $page + 1);
        }

    }

    // TODO should be events repo function
    private function isEventPersisted(User $user, EventDTO $eventData): bool
    {
        return $user->events()
            ->where('calendar_event_id', $eventData->id)
            ->where('changed_at', $eventData->changed)
            ->exists();
    }

    // TODO should be events repo function
    private function updateOrCreateEvent(User $user, EventDTO $eventData): void
    {
        /** @var Event $event */
        $event = $user->events()->updateOrCreate([
            'calendar_event_id' => $eventData->id
        ], [
            'title' => $eventData->title,
            'start_at' => $eventData->start,
            'end_at' => $eventData->end,
            'changed_at' => $eventData->changed,
        ]);

        // TODO probably not performant - too many updates will happen, and not nice code overall. Should probably connect with cache to avoid extra writing
        /** @var string $email */
        foreach ($eventData->accepted as $email) {
            if (str_contains($email, '@usergems')) { // FIXME hack
                continue;
            }
            /** @var  $personDTO */
            $personDTO = $this->personApi->getPerson($email);

            $companyDTO = $personDTO->company;

            $company = Company::updateOrCreate([
                'name' => $companyDTO->name,
            ], [
                'linkedin_url' => $companyDTO->linkedin_url,
                'employees' => $companyDTO->employees,
            ]);

            $event->persons()->updateOrCreate([
                'email' => $email
            ], [
                'first_name' => $personDTO->first_name,
                'last_name' => $personDTO->last_name,
                'avatar' => $personDTO->avatar,
                'title' => $personDTO->title,
                'linkedin_url' => $personDTO->linkedin_url,
                'company_id' => $company->id,
            ]);
        }

    }
}
