<?php
namespace App\Policies;
use App\Models\Task;
use App\Models\User;


class TaskPolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'manager', 'staff']);
    }

    public function view(User $user, Task $task)
    {
        return $user->role === 'admin' ||
               $user->id === $task->created_by ||
               $user->id === $task->assigned_to;
    }

    public function create(User $user)
    {
        return $user->status && in_array($user->role, ['admin', 'manager']);
    }

    public function update(User $user, Task $task)
    {
        return $user->role === 'admin' || $user->id === $task->created_by;
    }

    public function delete(User $user, Task $task)
    {
        return $user->role === 'admin' || $user->id === $task->created_by;
    }
}
