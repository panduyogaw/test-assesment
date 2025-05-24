<?php
namespace App\Services;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class TaskService
{
    public function createTask(array $data)
    {
        $user = Auth::user();
        if (!$user->status) {
            throw new \Exception('Inactive user cannot create tasks.');
        }

        if ($user->role === 'manager' && $data['assigned_to']) {
            $assignee = User::findOrFail($data['assigned_to']);
            if ($assignee->role !== 'staff') {
                throw new \Exception('Managers can only assign tasks to staff.');
            }
        }

        return Task::create([
            'id' => Uuid::uuid4()->toString(),
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'assigned_to' => $data['assigned_to'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'due_date' => $data['due_date'] ?? null,
            'created_by' => $user->id,
        ]);
    }

    public function updateTask(Task $task, array $data)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $task->created_by !== $user->id) {
            throw new \Exception('Unauthorized to update this task.');
        }

        if ($user->role === 'manager' && isset($data['assigned_to'])) {
            $assignee = User::findOrFail($data['assigned_to']);
            if ($assignee->role !== 'staff') {
                throw new \Exception('Managers can only assign tasks to staff.');
            }
        }

        $task->update($data);
        return $task;
    }

    public function deleteTask(Task $task)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $task->created_by !== $user->id) {
            throw new \Exception('Unauthorized to delete this task.');
        }
        $task->delete();
    }

    public function getTasksForUser()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return Task::with(['assignee', 'creator'])->get();
        } elseif ($user->role === 'manager') {
            return Task::with(['assignee', 'creator'])
                ->where('created_by', $user->id)
                ->orWhere('assigned_to', $user->id)
                ->get();
        } else {
            return Task::with(['assignee', 'creator'])
                ->where('assigned_to', $user->id)
                ->get();
        }
    }
}
