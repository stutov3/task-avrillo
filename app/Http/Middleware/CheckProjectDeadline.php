<?php

namespace App\Http\Middleware;

use App\Exceptions\DeadlinePassedException;
use App\Services\DeadlineCheckerService;
use Closure;

class CheckProjectDeadline
{
    private DeadlineCheckerService $deadlineCheckerService;

    public function __construct(DeadlineCheckerService $deadlineCheckerService)
    {
        $this->deadlineCheckerService = $deadlineCheckerService;
    }

    public function handle($request, Closure $next)
    {
        $projectId = $request->route('projectId');

        if ($projectId === null) {
            return $next($request);
        }

        try {
            $this->deadlineCheckerService->checkProjectDeadline((int)$projectId);
        } catch (DeadlinePassedException) {
            return response()->json(['error' => 'Project deadline has already passed.'], 422);
        }

        return $next($request);
    }
}
