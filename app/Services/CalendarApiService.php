<?php

namespace App\Services;

use App\Data\PaginatedEventDTO;
use App\Interfaces\CalendarApiInterface;
use Illuminate\Support\Facades\Http;

class CalendarApiService implements CalendarApiInterface
{
    public function __construct(
        private string $apiUrl = 'https://app.usergems.com/api/hiring/calendar-challenge/events'
    ) {
    }

    // TODO should return DTO instead of array
    public function getEvents(string $token, int $page = 1): PaginatedEventDTO
    {
        return PaginatedEventDTO::from(
            Http::withToken($token)
                ->get($this->apiUrl, ['page' => $page])
                ->json()
        );
    }
}
