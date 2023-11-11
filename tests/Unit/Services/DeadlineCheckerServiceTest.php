<?php

namespace Tests\Unit\Services;

use App\Exceptions\DeadlinePassedException;
use App\Models\Project;
use App\Services\DeadlineCheckerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeadlineCheckerServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var DeadlineCheckerService */
    private DeadlineCheckerService $deadlineCheckerService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->deadlineCheckerService = new DeadlineCheckerService();
    }

    /** @test */
    public function it_does_not_throw_exception_if_deadline_not_passed(): void
    {
        $project = Project::factory()->create([
            'deadline' => now()->addDay(), // Set a future deadline
        ]);

        $this->deadlineCheckerService->checkProjectDeadline($project->id);

        $this->assertTrue(true); // If no exception is thrown, the test passes
    }

    /** @test */
    public function it_updates_project_status_and_throws_exception_if_deadline_passed(): void
    {
        $project = Project::factory()->create([
            'deadline' => now()->subDay(), // Set a past deadline
        ]);

        $this->expectException(DeadlinePassedException::class);
        $this->deadlineCheckerService->checkProjectDeadline($project->id);

        $this->assertEquals(Project::COMPLETED, $project->fresh()->status);
    }
}
