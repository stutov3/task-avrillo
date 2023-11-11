<?php

namespace Tests\Unit\Services;

use App\Services\ProjectService;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class ProjectServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var ProjectService */
    private $projectService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->projectService = app(ProjectService::class);
    }

    /** @test */
    public function it_can_get_projects(): void
    {
        Project::factory()->count(5)->create();

        $projects = $this->projectService->getProjects();

        $this->assertInstanceOf(LengthAwarePaginator::class, $projects);
        $this->assertCount(5, $projects->items());
    }

    /** @test */
    public function it_can_create_a_project(): void
    {
        $projectData = [
            'title' => 'Test Project',
            'description' => 'This is a test project.',
            'deadline' => '2024-01-01',
        ];

        $project = $this->projectService->createProject($projectData);

        $this->assertInstanceOf(Project::class, $project);
        $this->assertDatabaseHas('projects', $projectData);
    }

    /** @test */
    public function it_can_update_a_project(): void
    {
        $project = Project::factory()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated description.',
        ];

        $updatedProject = $this->projectService->updateProject($project, $updatedData);

        $this->assertInstanceOf(Project::class, $updatedProject);
        $this->assertEquals('Updated Title', $updatedProject->title);
        $this->assertEquals('Updated description.', $updatedProject->description);
    }

    /** @test */
    public function it_can_delete_a_project(): void
    {
        $project = Project::factory()->create();

        $result = $this->projectService->deleteProject($project);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}

