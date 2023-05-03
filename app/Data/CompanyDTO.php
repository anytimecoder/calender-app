<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class CompanyDTO extends Data
{
    public function __construct(
        public string $name,
        public string $linkedin_url,
        public int $employees
    ) {
    }
}
