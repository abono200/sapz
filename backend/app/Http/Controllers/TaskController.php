<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskCommentRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use ApiResponse;

    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'priority', 'assignee_id', 'project_id', 'search']);
        $tasks = $this->taskService->getTasks($filters, $request->input('per_page', 15));
        return $this->paginatedResponse($tasks, 'Task list retrieved.');
    }

    public function store(CreateTaskRequest $request)
    {
        $task = $this->taskService->createTask($request->validated());
        return $this->successResponse($task, 'Task created successfully.', 201);
    }

    public function show(string $id)
    {
        $task = Task::with(['assignee', 'reporter', 'project', 'comments.user', 'subtasks'])->find($id);
        if (!$task) {
            return $this->errorResponse('Task not found.', 404);
        }
        return $this->successResponse($task, 'Task details retrieved.');
    }

    public function update(UpdateTaskRequest $request, string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->errorResponse('Task not found.', 404);
        }

        $updatedTask = $this->taskService->updateTask($task, $request->validated());
        return $this->successResponse($updatedTask, 'Task updated successfully.');
    }

    public function destroy(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->errorResponse('Task not found.', 404);
        }

        $this->taskService->deleteTask($task);
        return $this->successResponse(null, 'Task deleted successfully.');
    }

    public function addComment(CreateTaskCommentRequest $request, string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->errorResponse('Task not found.', 404);
        }

        $comment = $this->taskService->addComment($task, $request->comment);
        return $this->successResponse($comment, 'Task comment added.', 201);
    }
}
