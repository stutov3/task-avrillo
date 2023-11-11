<?php

namespace App\DTO;

class StatisticsDTO
{
    private int $totalProjects = 0;
    private int $totalTasks = 0;
    private int $completedTasks = 0;

    /**
     * @param int $totalProjects
     * @param int $totalTasks
     * @param int $completedTasks
     */
    public function __construct(int $totalProjects, int $totalTasks, int $completedTasks)
    {
        $this->totalProjects = $totalProjects;
        $this->totalTasks = $totalTasks;
        $this->completedTasks = $completedTasks;
    }

    /**
     * @return int
     */
    public function getTotalProjects(): int
    {
        return $this->totalProjects;
    }

    /**
     * @param int $totalProjects
     * @return StatisticsDTO
     */
    public function setTotalProjects(int $totalProjects): StatisticsDTO
    {
        $this->totalProjects = $totalProjects;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalTasks(): int
    {
        return $this->totalTasks;
    }

    /**
     * @param int $totalTasks
     * @return StatisticsDTO
     */
    public function setTotalTasks(int $totalTasks): StatisticsDTO
    {
        $this->totalTasks = $totalTasks;
        return $this;
    }

    /**
     * @return int
     */
    public function getCompletedTasks(): int
    {
        return $this->completedTasks;
    }

    /**
     * @param int $completedTasks
     * @return StatisticsDTO
     */
    public function setCompletedTasks(int $completedTasks): StatisticsDTO
    {
        $this->completedTasks = $completedTasks;
        return $this;
    }
}
