<?php

namespace App\Http\Controllers;

use App\Repository\ProjectRepositoryInterface;
use Illuminate\Http\Request;
use App\Repository\UserRepositoryInterface;

class DashboardController extends Controller
{
    private $projectRepository;
    private $userRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository, ProjectRepositoryInterface $projectRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
    }

    public function index()
    {
        $users = $this->userRepository->all();
        $projects = $this->projectRepository->all();
        return view('taskDashboard')->with([
            'users' => $users,
            'projects' => $projects    
    ]);
    }
}
