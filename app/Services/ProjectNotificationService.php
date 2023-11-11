<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Notifications\ProjectDeadlineNotification;
use App\Notifications\TaskAssignedNotification;
use Carbon\Carbon;

class ProjectNotificationService
{
    public function sendProjectDeadlineNotifications(): void
    {
        $deadlineTime = Carbon::now()->addMinutes(10);

        $projects = Project::where('deadline', '=', $deadlineTime)->get();

        // Dispatch the notification for each project
        foreach ($projects as $project) {
            $project->users->each(function ($user) use ($project) {
                $user->notify(new ProjectDeadlineNotification($project));
            });
        }
    }

    public function sendTaskAssigmentNotification(int $userId, int $taskId): void
    {
        $user = User::find($userId);
        $task = Task::find($taskId);

        if ($user && $task) {
            $user->notify(new TaskAssignedNotification($task));
        }
    }
}
