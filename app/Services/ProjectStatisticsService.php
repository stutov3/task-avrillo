<?php

namespace App\Services;

use App\Contracts\ProjectStatisticsServiceInterface;
use App\DTO\StatisticsDTO;
use App\Models\Project;
use App\Models\Task;

class ProjectStatisticsService implements ProjectStatisticsServiceInterface
{
    public function getProjectStatistics(): StatisticsDTO
    {
        $completedTasks = Task::where('status', Task::COMPLETED)->count();

        return new StatisticsDTO(Project::count(), Task::count(), $completedTasks);
    }
}
