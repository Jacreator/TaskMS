<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskFile;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\UpdateTaskRequest;
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
        $validated = $request->validated();
        $data = [
            'name' => $validated['name'],
            'duedate' => $validated['duedate'],
            'priority' => $validated['priority'] ?? Task::PRIORITY_LEVEL_LOW,
            'project_id' => $validated['taskProject'],
            'user_id' => $validated['user']
        ];
        $task = $this->taskRepository->createTask($data);

        if($task && $request->hasFile('photos')){
            foreach ($validated['photos'] as  $file) {
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();
        // dd($request->toArray());
        $task->name = $validated['name'];
        $task->user_id = $validated['user'];
        $task->priority = $validated['priority'];
        $task->project_id = $validated['taskProject'];
        $task->duedate = is_null($validated['duedate']) ? $task->duedate : $validated['duedate'];

        if ($request->hasFile('photos')) {
            foreach ($request->photos as $file) {
                $filename = strtr(pathinfo(time() . '_' . $file->getClientOriginalName(), PATHINFO_FILENAME), [' ' => '', '.' => '']) . '.' . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                
                $file->move('images', $filename);

                // save to DB
                TaskFile::create([
                    'task_id'  => $task->id,
                    'filename' => $filename  
                ]);
            }
        }

        $task->save();
        return redirect()->route('workspace');
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

    public function deleteFile(TaskFile $taskFile){
        
        unlink(public_path() . '/images/' . $taskFile->filename);

        // delete entry from database
        $taskFile->delete();
        Session::flash('success', 'File Deleted');
        return redirect()->back(); 
    }
}
