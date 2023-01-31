<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Tasks/Index', [
            'inertiaTasks' => Auth::user()->tasks()->select(['id', 'name', 'deadline', 'completed'])->getResults()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Tasks/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {

        $request->validated();

        Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'user_id' => Auth::user()->id
        ]);

        return Inertia::location(route('tasks.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        return Inertia::render('Tasks/Edit', [
            "task" => $task->only(['name', 'description', 'deadline', 'id'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update([
            'name' => $request->name,
            'description' => $request->description,
            'deadline' => $request->deadline
        ]);

        return Inertia::location(route('tasks.index'));
    }

    public function getDescription(Request $request, int $id): JsonResponse
    {
        return response()->json(['description' => Task::find($id)->description]);
    }

    public function toggleStatus(Request $request, int $id): JsonResponse
    {
        return new JsonResponse(Task::find($id)->toggleStatus()->select(['id', 'name', 'deadline', 'completed'])->find($id));
    }

    public function filterTasks(Request $request): JsonResponse
    {
        $tasks = new Task();
        $tasks = $tasks->filterByQueryParams($request->all(), Auth::user());
        return new JsonResponse($tasks);
    }
}
