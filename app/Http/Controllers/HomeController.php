<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\UserRepositoryInterface;

class HomeController extends Controller
{
    private $userRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = $this->userRepository->all();
        return view('home')->with('users', $users);
    }
}
