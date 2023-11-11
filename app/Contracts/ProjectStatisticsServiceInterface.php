<?php

namespace App\Contracts;

use App\DTO\StatisticsDTO;

interface ProjectStatisticsServiceInterface
{
    public function getProjectStatistics(): StatisticsDTO;
}
