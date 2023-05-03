<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function findAll(): Collection;

    public function findById(int $id): Model;
}
