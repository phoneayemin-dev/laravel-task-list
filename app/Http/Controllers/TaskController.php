<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\StoreTaskRequest;
use App\Interfaces\TaskRepositoryInterface;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $taskRepoInterface;

    function __construct(TaskRepositoryInterface $taskRepositoryInterface)
    {
        $this->taskRepoInterface = $taskRepositoryInterface;
    }

    public function index()
    {
        //
        return view("tasks.index", [ 'tasks' => Task::orderBy('created_at', 'ASC')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        //
        $validated = $request->validated();

        $this->taskRepoInterface->createTask([
            'name' => $validated['name'],
            'user_id' => Auth::id(),
        ]);

        return view('tasks.index', [ 'tasks' => $this->taskRepoInterface->getTasksByUser(Auth::id())]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteTaskRequest $request, $id)
    {
        $this->taskRepoInterface->deleteTask($id);
        return view("tasks.index", [ "tasks" => $this->taskRepoInterface->getTasksByUser(Auth::id())]);
    }
}
