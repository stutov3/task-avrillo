<?php

namespace App\Http\Resources;

use App\DTO\StatisticsDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectStatisticsResource extends JsonResource
{

    private StatisticsDTO $statisticsDTO;

    public function __construct(StatisticsDTO $statisticsDTO)
    {
        $this->statisticsDTO = $statisticsDTO;
        parent::__construct($statisticsDTO);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_projects' => $this->statisticsDTO->getTotalProjects(),
            'total_tasks' => $this->statisticsDTO->getTotalTasks(),
            'completed_tasks' => $this->statisticsDTO->getCompletedTasks(),
        ];
    }
}
