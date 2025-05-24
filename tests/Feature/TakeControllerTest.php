<?php
namespace Tests\Feature;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_task()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin, 'sanctum');

        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'due_date' => now()->addDay()->toDateString(),
            'status' => 'pending',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    public function test_staff_cannot_see_others_tasks()
    {
        $staff = User::factory()->create(['role' => 'staff']);
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['created_by' => $otherUser->id]);

        $this->actingAs($staff, 'sanctum');
        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }
}
