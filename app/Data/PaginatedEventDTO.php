<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class PaginatedEventDTO extends Data
{

    public function __construct(
        public int $total,
        public int $per_page,
        public int $current_page,

        #[DataCollectionOf(EventDTO::class)]
        public DataCollection $data,
    ) {
    }
}
