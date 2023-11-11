<?php

namespace Tests\Unit\Services;

use App\DTO\StatisticsDTO;
use App\Models\Project;
use App\Models\Task;
use App\Services\ProjectStatisticsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectStatisticsServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var ProjectStatisticsService */
    private $projectStatisticsService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->projectStatisticsService = app(ProjectStatisticsService::class);
    }

    /** @test */
    public function it_can_get_project_statistics(): void
    {
        // Create projects and tasks for testing
        Project::factory()->count(5)->create();
        // Create ten completed tasks for a subset of projects
        Project::inRandomOrder()->take(2)->get()->each(function ($project) {
            Task::factory()->count(5)->create(['status' => Task::COMPLETED, 'project_id' => $project->id]);
        });

        $statistics = $this->projectStatisticsService->getProjectStatistics();

        $this->assertInstanceOf(StatisticsDTO::class, $statistics);
        $this->assertEquals(5, $statistics->getTotalProjects());
        $this->assertEquals(10, $statistics->getTotalTasks());
        $this->assertEquals(10, $statistics->getCompletedTasks());
    }
}
