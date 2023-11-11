<?php

namespace App\Contracts;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TaskServiceInterface
{
    public function createTask(array $data): Task;

    public function updateTask(Task $task, array $data): Task;

    public function deleteTask(Task $task): bool;

    public function assignTask(Task $task, ?int $assignedUserId = null);

    public function getTasks(): LengthAwarePaginator;
}
