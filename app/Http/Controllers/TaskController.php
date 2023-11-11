<?php

namespace App\Http\Controllers;

use App\Contracts\TaskServiceInterface;
use App\Http\Requests\Tasks\TaskCreateRequest;
use App\Http\Requests\Tasks\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskResourceCollection;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class TaskController extends Controller
{
    private TaskServiceInterface $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): TaskResourceCollection
    {
        $tasks = $this->taskService->getTasks();
        return new TaskResourceCollection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskCreateRequest $request): JsonResponse
    {
        $data = $request->all();

        try {
            $this->taskService->createTask($data);

            return new JsonResponse(['message' => 'Task created successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'Task creation failed'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, Task $task): JsonResponse
    {
        $data = $request->validated();

        try {
            $this->taskService->updateTask($task, $data);

            return new JsonResponse(['message' => 'Task updated successfully'], Response::HTTP_OK);
        } catch (\Exception) {
            return new JsonResponse(['message' => 'Task update failed'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): JsonResponse
    {
        try {
            $this->taskService->deleteTask($task);

            return new JsonResponse(['message' => 'Task deleted successfully'], Response::HTTP_NO_CONTENT);
        } catch (\Exception) {
            return new JsonResponse(['message' => 'Task delete failed'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function assignTask(Task $task, ?User $user = null): JsonResponse
    {
        $assignedUserId = $user ? $user->getId() : Auth::id();

        try {
            $this->taskService->assignTask($task, $assignedUserId);

            return new JsonResponse(['message' => 'Task assigned successfully'], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return new JsonResponse(['message' => 'Task assigned failed'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


    }
}
