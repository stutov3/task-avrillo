<?php

namespace Tests\Unit\Services;

use App\Events\TaskAssigned;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var TaskService */
    private $taskService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskService = app(TaskService::class);
    }

    /** @test */
    public function it_can_create_a_task(): void
    {
        $project = Project::factory()->create();

        $taskData = [
            'title' => 'Test Task',
            'description' => 'This is a test task.',
            'project_id' => $project->id
        ];

        $task = $this->taskService->createTask($taskData);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertDatabaseHas('tasks', $taskData);
    }

    /** @test */
    public function it_can_update_a_task(): void
    {
        $task = Task::factory()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated description.',
        ];

        $updatedTask = $this->taskService->updateTask($task, $updatedData);

        $this->assertInstanceOf(Task::class, $updatedTask);
        $this->assertEquals('Updated Title', $updatedTask->title);
        $this->assertEquals('Updated description.', $updatedTask->description);
    }

    /** @test */
    public function it_can_delete_a_task(): void
    {
        $task = Task::factory()->create();

        $result = $this->taskService->deleteTask($task);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function it_can_assign_a_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $assignedUserId = $user->id;

        Event::fake();

        $assignedTask = $this->taskService->assignTask($task, $assignedUserId);

        $this->assertInstanceOf(Task::class, $assignedTask);
        $this->assertEquals($assignedUserId, $assignedTask->user_id);
    }

    /** @test */
    public function it_can_get_tasks(): void
    {
        Task::factory()->count(5)->create();

        $tasks = $this->taskService->getTasks();

        $this->assertInstanceOf(LengthAwarePaginator::class, $tasks);
        $this->assertCount(5, $tasks->items());
    }
}

