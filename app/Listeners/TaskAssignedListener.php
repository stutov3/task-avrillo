<?php

namespace App\Listeners;

use App\Events\TaskAssigned;
use App\Jobs\SendTaskAssignedNotificationJob;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaskAssignedListener
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param TaskAssigned $event
     * @return void
     */
    public function handle(TaskAssigned $event): void
    {
        $task = $event->getTask();
        $assignedUser = $event->getAssignedUser();

        SendTaskAssignedNotificationJob::dispatch($assignedUser->id, $task->id)->onQueue('emails');
    }
}
