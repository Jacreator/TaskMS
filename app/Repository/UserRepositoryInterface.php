<?php

namespace App\Repository;

use App\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;
}
