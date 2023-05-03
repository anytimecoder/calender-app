<?php

namespace App\Interfaces;

use App\Data\PersonDTO;

interface PersonApiInterface
{
    public function getPerson(string $email): PersonDTO;
}
