<?php

namespace App\Repository\Eloquent;

use App\Models\Task;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\TaskRepositoryInterface;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    /**
     * TaskRepository constructor.
     *
     * @param Task $model
     */
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all()->SortByDesc('priority');
    }

    public function createTask(array $data): ?Model
    {
        return $this->model->create($data);
    }

    public function findTask($id): ?Model
    {
        return $this->model->find($id);
    }

    public function updateTask(array $data, $id): ?int
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function deleteTask($id): ?int
    {
        return $this->model->where('id', $id)->delete($id);
    }
}