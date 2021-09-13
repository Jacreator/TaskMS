<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskFile;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Log;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Session;
use App\Repository\TaskRepositoryInterface;

use App\Repository\UserRepositoryInterface;
use App\Repository\ProjectRepositoryInterface;

class TaskController extends Controller
{
    private $taskRepository;
    private $projectRepository;
    private $userRepository;

    public function __construct(
        TaskRepositoryInterface $taskRepository,
        UserRepositoryInterface $userRepository,
        ProjectRepositoryInterface $projectRepository
    )
    {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode($this->taskRepository->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $data = [
            'name' => $request->name,
            'duedate' => $request->duedate,
            'priority' => $request->priority ?? Task::PRIORITY_LEVEL_LOW,
            'project_id' => $request->taskProject,
            'user_id' => $request->user
        ];
        $task = $this->taskRepository->createTask($data);

        if($task && $request->hasFile('photos')){
            foreach ($request->photos as  $file) {
                $filename = strtr(pathinfo(time() . '_' . $file->getClientOriginalName(), PATHINFO_FILENAME), [' ' => '', '.' => '']) . '.' . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                $file->move('images', $filename);
                TaskFile::create([
                    'task_id'  => $task->id, 
                    'filename' => $filename
                ]);
            }
        }
        Session::flash('success', 'Task Created');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $users = $this->userRepository->all();
        $projects = $this->projectRepository->all();
        $taskFiles = TaskFile::where('task_id', '=', $task)->get();

        return view('task.edit')->with([
            'task' => $task,
            'users' => $users,
            'projects' => $projects,
            'taskFiles' => $taskFiles
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $task = $this->taskRepository->deleteTask($request->id);
        if($task){
            $delete_files = TaskFile::whereTaskId($request->id)->get();
            foreach ($delete_files as $file) {
                // remove  file from public directory
                unlink(public_path() . '/images/' . $file->filename);
                // delete entry from database
                $file->delete();
            }
        }
        return response()->noContent();;
    }

    public function reorder(Request $request){
        
        for($count = 0; $count < count($request->priority_id_array); $count++) {
            
            $task = $this->taskRepository->findTask($request->priority_id_array[$count]);
            if($count === 0){
                $this->taskRepository->updateTask([
                    'priority' => Task::PRIORITY_LEVEL_HIGH,
                ], $task->id);
            }else{
                $this->taskRepository->updateTask([
                    'priority' => Task::PRIORITY_LEVEL_LOW,
                ], $task->id);
            }
            
        }
        
        return response()->json('true');
    }
}
