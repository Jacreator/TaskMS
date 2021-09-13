<?php

namespace App\Http\Controllers;

use App\Repository\ProjectRepositoryInterface;
use App\Repository\TaskRepositoryInterface;
use Illuminate\Http\Request;
use App\Repository\UserRepositoryInterface;

class DashboardController extends Controller
{
    private $projectRepository;
    private $userRepository;
    private $taskRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserRepositoryInterface $userRepository, 
        ProjectRepositoryInterface $projectRepository,
        TaskRepositoryInterface $taskRepository
        )
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        $users = $this->userRepository->all();
        $projects = $this->projectRepository->all();
        $tasks = $this->taskRepository->all();
        return view('taskDashboard')->with([
            'users' => $users,
            'projects' => $projects,
            'tasks' => $tasks   
        ]);
    }
}
