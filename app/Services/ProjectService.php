<?php

namespace App\Services;

use App\Contracts\ProjectServiceInterface;
use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProjectService implements ProjectServiceInterface
{

    public function getProjects(): LengthAwarePaginator
    {
        return Project::paginate();
    }

    public function createProject(array $data): Project
    {
        return Project::create($data);
    }

    public function updateProject(Project $project, array $data): Project
    {
        $project->update($data);

        return $project;
    }

    public function deleteProject(Project $project): bool
    {
        return (bool)$project->delete();
    }
}
