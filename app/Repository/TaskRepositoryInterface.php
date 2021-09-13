<?php

namespace App\Repository;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface TaskRepositoryInterface
{
    public function all(): Collection;

    public function findTask($id): ?Model;

    public function createTask(array $attributes): ?Model;

    public function updateTask(array $attributes, $id): ?int;

    public function deleteTask($id): ?Model;
}