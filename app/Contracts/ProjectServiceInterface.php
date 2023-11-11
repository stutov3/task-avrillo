<?php

namespace App\Contracts;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProjectServiceInterface
{
    public function getProjects(): LengthAwarePaginator;

    public function createProject(array $data): Project;

    public function updateProject(Project $project, array $data): Project;

    public function deleteProject(Project $project): bool;
}
