<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    /** @test */
    public function it_can_get_tasks()
    {
        Task::factory(2)->create();

        $response = $this->get('/api/tasks');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure(['data' => [['id', 'title', 'description', 'status', 'project_id']]]);
    }

    /** @test */
    public function it_can_create_a_task()
    {
        $taskData = [
            'title' => 'New Task',
            'description' => 'Task description',
            'status' => 'in-progress',
            'project_id' => Project::factory()->create()->id,
        ];

        $response = $this->post('/api/tasks', $taskData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['message' => 'Task created successfully']);

        $this->assertDatabaseHas('tasks', ['title' => 'New Task']);
    }

    /** @test */
    public function it_can_get_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->get("/api/tasks/{$task->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['data' => ['id' => $task->id]]);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $task = Task::factory()->create();

        $updatedData = ['title' => 'Updated Title', 'status' => Task::COMPLETED];

        $response = $this->put("/api/tasks/{$task->id}", $updatedData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Task updated successfully']);

        $this->assertDatabaseHas(
            'tasks',
            ['id' => $task->id, 'title' => 'Updated Title', 'status' => Task::COMPLETED]
        );
    }

    /** @test */
    public function it_can_delete_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->delete("/api/tasks/{$task->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function it_can_assign_a_task_to_a_user()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $task = Task::factory()->create(['project_id' => $project->id]);

        Passport::actingAs(
            $user
        );

        $response = $this->post("/api/tasks/{$task->id}/assign", ['user_id' => $user->id]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Task assigned successfully']);
    }
}
