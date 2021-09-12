<?php

namespace App\Repository\Eloquent;

use App\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\ProjectRepositoryInterface;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Project $model
     */
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    public function createProject(array $data): ?Model
    {
        return $this->model->create($data);
    }
}