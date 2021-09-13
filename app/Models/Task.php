<?php

namespace App\Models;

use App\models\Project;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    const COMPLETE = 1;
    const NOT_COMPLETED = 0;

    const PRIORITY_LEVEL_HIGH = 1;
    const PRIORITY_LEVEL_LOW = 0;
     
    protected $fillable = [
        'project_id', 
        'user_id', 
        'name', 
        'description', 
        'priority', 
        'duedate'
    ];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taskfiles()
    {
        return $this->hasMany(TaskFile::class);
    }

    protected static function boot()
    {
        parent::boot();

        Task::creating(function ($model) {
            $model->position = Task::max('position') + 1;
        });
    }
}
