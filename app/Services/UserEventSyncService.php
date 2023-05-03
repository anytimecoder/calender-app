<?php

namespace App\Services;

use App\Data\EventDTO;
use App\Data\PaginatedEventDTO;
use App\Models\User;
use Illuminate\Support\Facades\Log;

// TODO add interface
class UserEventSyncService
{

    public function __construct(
        private CalendarApiService $calendarApiService
    ) {
    }

    public function sync(User $user): void
    {
        try {
            $this->checkAndUpdateEvents($user);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage(), [
                'user' => $user->id,
            ]);
        }

    }

    private function checkAndUpdateEvents(User $user, int $page = 1): void
    {
        $synced = false;
        $paginatedEvents = $this->calendarApiService->getEvents($user->calendar_api_token);
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

        $moreResults = $paginatedEvents->current_page * $paginatedEvents->per_page < $paginatedEvents->total;
        if (!$synced && $moreResults) {
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
        $user->events()->updateOrCreate([
            'calendar_event_id' => $eventData->id
        ], [
            'title' => $eventData->title,
            'start_at' => $eventData->start,
            'end_at' => $eventData->end,
            'changed_at' => $eventData->changed,
        ]);
    }
}
