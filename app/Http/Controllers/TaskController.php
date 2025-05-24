<?php
namespace App\Http\Controllers;
use App\Models\Task;
use App\Services\TaskService;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        return $this->taskService->getTasksForUser();
    }

    public function store(TaskRequest $request)
    {
        $task = $this->taskService->createTask($request->validated());
        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return $task->load(['assignee', 'creator']);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $task = $this->taskService->updateTask($task, $request->validated());
        return $task;
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $this->taskService->deleteTask($task);
        return response()->json(null, 204);
    }
    public function export()
{
    $tasks = $this->taskService->getTasksForUser();
    $filename = 'tasks_' . now()->format('YmdHis') . '.csv';
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
    ];

    $callback = function () use ($tasks) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['Title', 'Description', 'Status', 'Due Date', 'Assigned To']);
        foreach ($tasks as $task) {
            fputcsv($file, [
                $task->title,
                $task->description,
                $task->status,
                $task->due_date,
                $task->assignee ? $task->assignee->name : 'Unassigned',
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}
