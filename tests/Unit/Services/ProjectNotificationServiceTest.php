<?php

namespace Tests\Unit\Services;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Notifications\ProjectDeadlineNotification;
use App\Notifications\TaskAssignedNotification;
use App\Services\ProjectNotificationService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Tests\TestCase;

class ProjectNotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var ProjectNotificationService */
    private $projectNotificationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->projectNotificationService = new ProjectNotificationService();
    }

    /** @test */
    public function it_sends_project_deadline_notifications(): void
    {
        Notification::fake();

        $project = Project::factory()
            ->has(User::factory()->count(2))
            ->create(['deadline' => Carbon::now()->addMinutes(10)]);

        $this->projectNotificationService->sendProjectDeadlineNotifications();

        Notification::assertSentTo($project->users, ProjectDeadlineNotification::class);
    }

    /** @test */
    public function it_sends_task_assignment_notification(): void
    {
        Notification::fake();
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $this->projectNotificationService->sendTaskAssigmentNotification($user->id, $task->id);

        Notification::assertSentTo($user, TaskAssignedNotification::class);
    }
}
