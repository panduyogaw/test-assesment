<?php
namespace App\Console\Commands;
use App\Models\Task;
use App\Models\ActivityLog;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

class CheckOverdueTasks extends Command
{
    protected $signature = 'tasks:check-overdue';
    protected $description = 'Check for overdue tasks and log them';

    public function handle()
    {
        $overdueTasks = Task::where('due_date', '<', now())
            ->where('status', '!=', 'done')
            ->get();

        foreach ($overdueTasks as $task) {
            ActivityLog::create([
                'id' => Uuid::uuid4()->toString(),
                'user_id' => $task->created_by,
                'action' => 'task_overdue',
                'description' => "Task overdue: {$task->id}",
                'logged_at' => now(),
            ]);
            $this->info("Logged overdue task: {$task->id}");
        }
    }
}
