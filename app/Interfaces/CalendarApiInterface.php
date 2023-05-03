<?php

namespace App\Interfaces;

use App\Data\PaginatedEventDTO;

interface CalendarApiInterface
{
    public function getEvents(string $token, int $page = 1): PaginatedEventDTO;
}
