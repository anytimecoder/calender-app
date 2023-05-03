<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UserRepository implements RepositoryInterface
{
    public function findAll(): Collection
    {
        return User::all();
    }

    public function findById(int $id): Model
    {
        return User::query()->findOrFail($id);
    }
}
