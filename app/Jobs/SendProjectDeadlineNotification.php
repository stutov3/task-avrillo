<?php

namespace App\Jobs;

use App\Services\ProjectNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendProjectDeadlineNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 30;

    private ProjectNotificationService $notificationService;

    public function __construct(ProjectNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(): void
    {
        $this->notificationService->sendProjectDeadlineNotifications();
    }
}
