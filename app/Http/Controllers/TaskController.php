<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Patch;
use Spatie\RouteAttributes\Attributes\Resource;
use Spatie\RouteAttributes\Attributes\Middleware;
use Illuminate\Http\Client\Request as ClientRequest;
use Laravel\Jetstream\Http\Middleware\AuthenticateSession;



#[Middleware([
    'auth:sanctum',
    AuthenticateSession::class,
    'verified'
])]
#[Resource(
    resource: 'tasks',
    parameters: ['tasks' => 'task:id'],
    except: ['destroy', 'show'],
)]
class TaskController extends Controller
{

    public function index(): \Inertia\Response
    {
        return Inertia::render('Tasks/Index', [
            'inertiaTasks' => Auth::user()->tasks()->select(['id', 'name', 'deadline', 'completed'])->getResults()
        ]);
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('Tasks/Create');
    }

    public function store(StoreTaskRequest $request): Response
    {

        $request->validated();

        Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'user_id' => Auth::user()->id
        ]);

        return Inertia::location('Tasks/Index');
    }

    public function edit(Task $task): \Inertia\Response
    {
        $this->authorize('update', $task);

        return Inertia::render('Tasks/Edit', [
            "task" => $task->only(['name', 'description', 'deadline', 'id'])
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): Response
    {
        $this->authorize('update', $task);

        $request->validated();

        $task->update([
            'name' => $request->name,
            'description' => $request->description,
            'deadline' => $request->deadline
        ]);

        return Inertia::location('Tasks/Index');
    }

    #[Get('api/tasks/description/{id}', name: 'tasks.description')]
    public function getDescription(Request $request, int $id): JsonResponse
    {
        return new JsonResponse(['description' => Task::find($id)->description]);
    }

    #[Patch('api/tasks/toggle-status/{id}', name: 'tasks.toggleStatus')]
    public function toggleStatus(Request $request, int $id): JsonResponse
    {
        return new JsonResponse(Task::find($id)->toggleStatus()->select(['id', 'name', 'deadline', 'completed'])->find($id));
    }

    #[Get('api/tasks/filtered', name: 'tasks.filtered')]
    public function filterTasks(Request $request): JsonResponse
    {
        $tasks = new Task();
        $tasks = $tasks->filterByQueryParams($request->all(), Auth::user());
        return new JsonResponse($tasks);
    }
}
