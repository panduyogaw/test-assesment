<?php
namespace Tests\Unit;
use App\Models\User;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $taskService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskService = new TaskService();
    }

    public function test_manager_can_only_assign_to_staff()
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($manager);

        $this->expectException(\Exception::class);
        $this->taskService->createTask([
            'title' => 'Test Task',
            'assigned_to' => $admin->id,
            'due_date' => now()->addDay()->toDateString(),
        ]);
    }

    public function test_inactive_user_cannot_create_task()
    {
        $user = User::factory()->create(['status' => false]);
        $this->actingAs($user);

        $this->expectException(\Exception::class);
        $this->taskService->createTask([
            'title' => 'Test Task',
            'due_date' => now()->addDay()->toDateString(),
        ]);
    }
}
