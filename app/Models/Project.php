<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
