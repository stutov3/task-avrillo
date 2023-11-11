<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;
use Illuminate\Http\Response;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_projects()
    {
        Project::factory(2)->create();

        $response = $this->get('/api/projects');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure(['data' => [['id', 'title', 'description', 'status', 'deadline']]]);
    }

    /** @test */
    public function it_can_create_a_project()
    {
        $data = [
            'title' => 'New Project',
            'description' => 'Project description',
            'deadline' => now()->addDays(10)->toDateString(),
        ];

        $response = $this->post('/api/projects', $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['message' => 'Project created successfully']);

        $this->assertDatabaseHas('projects', ['title' => 'New Project']);
    }

    /** @test */
    public function it_can_get_a_project()
    {
        $project = Project::factory()->create();

        $response = $this->get("/api/projects/{$project->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['data' => ['id' => $project->id]]);
    }

    /** @test */
    public function it_can_update_a_project()
    {
        $project = Project::factory()->create();
        $updatedData = ['title' => 'Updated Title'];

        $response = $this->put("/api/projects/{$project->id}", $updatedData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Project updated successfully']);

        $this->assertDatabaseHas('projects', ['id' => $project->id, 'title' => 'Updated Title']);
    }

    /** @test */
    public function it_can_delete_a_project()
    {
        $project = Project::factory()->create();

        $response = $this->delete("/api/projects/{$project->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    /** @test */
    public function it_can_get_project_statistics()
    {
        $response = $this->get('/api/projects/statistics');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => ['total_projects', 'total_tasks', 'completed_tasks']]);
    }
}
