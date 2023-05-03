<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class PersonDTO extends Data
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $avatar,
        public string $title,
        public string $linkedin_url,
        public CompanyDTO $company,
    ) {
    }
}
