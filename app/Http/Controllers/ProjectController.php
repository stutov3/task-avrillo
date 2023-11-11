<?php

namespace App\Http\Controllers;

use App\Contracts\ProjectServiceInterface;
use App\Contracts\ProjectStatisticsServiceInterface;
use App\Http\Requests\Projects\ProjectCreateRequest;
use App\Http\Requests\Projects\ProjectUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectResourceCollection;
use App\Http\Resources\ProjectStatisticsResource;
use App\Models\Project;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProjectController extends Controller
{
    private ProjectServiceInterface $projectService;
    private ProjectStatisticsServiceInterface $projectStatisticsService;

    public function __construct(
        ProjectServiceInterface $projectService,
        ProjectStatisticsServiceInterface $projectStatisticsService
    ) {
        $this->projectService = $projectService;
        $this->projectStatisticsService = $projectStatisticsService;

        $this->middleware('check-deadline', ['only' => ['show']]);
    }

    public function index(): ProjectResourceCollection
    {
        $projects = $this->projectService->getProjects();

        return new ProjectResourceCollection($projects);
    }

    public function store(ProjectCreateRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
           $this->projectService->createProject($data);

            return new JsonResponse(['message' => 'Project created successfully'], Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return new JsonResponse(['message' => 'Project creation failed'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function show(Project $project): ProjectResource
    {
        return new ProjectResource($project);
    }

    public function update(ProjectUpdateRequest $request, Project $project): JsonResponse
    {
        $data = $request->validated();

        try {
            $this->projectService->updateProject($project, $data);

            return new JsonResponse(['message' => 'Project updated successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return new JsonResponse(['message' => 'Project update failed'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }


    public function destroy(Project $project): JsonResponse
    {
        try {
            $this->projectService->deleteProject($project);

            return new JsonResponse(['message' => 'Project deleted successfully'], Response::HTTP_NO_CONTENT);
        } catch (\Exception) {
            return new JsonResponse(['message' => 'Project delete failed'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function projectStatistics(): ProjectStatisticsResource
    {
        $statistics = $this->projectStatisticsService->getProjectStatistics();

        return new ProjectStatisticsResource($statistics);
    }
}
