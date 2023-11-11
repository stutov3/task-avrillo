<?php

namespace App\Services;

use App\Contracts\TaskServiceInterface;
use App\Events\TaskAssigned;
use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskService implements TaskServiceInterface
{
    public function createTask(array $data): Task
    {
        return Task::create($data);
    }

    public function updateTask(Task $task, array $data): Task
    {
        $task->update($data);

        return $task;
    }

    public function deleteTask(Task $task): bool
    {
        return (bool)$task->delete();
    }

    public function assignTask(Task $task, ?int $assignedUserId = null): Task
    {
        $task->user_id = $assignedUserId;
        $task->save();

        event(new TaskAssigned($task));

        return $task;
    }

    public function getTasks(): LengthAwarePaginator
    {
        return Task::paginate();
    }
}
