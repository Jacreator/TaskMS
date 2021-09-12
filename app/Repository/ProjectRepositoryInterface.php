<?php

namespace App\Repository;


use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProjectRepositoryInterface
{
    public function all(): Collection;

    public function createProject(array $attributes): ?Model;
}
