<?php

namespace App\Services;

use App\Exceptions\DeadlinePassedException;
use App\Models\Project;

class DeadlineCheckerService
{
    /**
     * @throws DeadlinePassedException
     */
    public function checkProjectDeadline(int $projectId): void
    {
        $project = Project::find($projectId);

        if ($project !== null && now() > $project->deadline) {
            $project->update(['status' => Project::COMPLETED]);
            throw new DeadlinePassedException();
        }
    }
}
