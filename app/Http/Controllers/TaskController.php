<?php

namespace App\Http\Controllers;

use App\Commands\Task\CreateTaskCommand;
use App\Commands\Task\DeleteTaskCommand;
use App\Commands\Task\UpdateTaskCommand;
use App\Handlers\CreateTaskCommandHandler;
use App\Handlers\GetTaskQueryHandler;
use App\Handlers\ListTaskQueryHandler;
use App\Handlers\UpdateTaskCommandHandler;
use App\Http\Requests\Task\IndexRequest;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Queries\Task\GetTaskQuery;
use App\Queries\Task\ListTaskQuery;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index(IndexRequest $request, ListTaskQueryHandler $handler): JsonResponse
    {
        $indexTaskQuery = new ListTaskQuery(
            auth()->id(),
            $request->string('status'),
        );

        $tasks = $handler->handle($indexTaskQuery);

        return response()->json([
            'tasks' => $tasks->toArray(),
        ], Response::HTTP_OK);
    }

    public function store(StoreRequest $request, CreateTaskCommandHandler $handler): JsonResponse
    {
        $createTaskCommand = new CreateTaskCommand(
            auth()->id(),
            $request->string('title'),
            $request->string('description'),
        );

        $task = $handler->handle($createTaskCommand);

        return response()->json([
            'task' => $task,
        ], Response::HTTP_CREATED);
    }

    public function show(string $id, GetTaskQueryHandler $handler): JsonResponse
    {
        $getTaskQuery = new GetTaskQuery(
            auth()->id(),
            $id,
        );

        $task = $handler->handle($getTaskQuery);

        return response()->json([
            'task' => $task,
        ], Response::HTTP_OK);
    }

    public function update(UpdateRequest $request, string $id, UpdateTaskCommandHandler $handler): JsonResponse
    {
        $updateTaskCommand = new UpdateTaskCommand(
            auth()->id(),
            $id,
            $request->string('title'),
            $request->string('description'),
            $request->integer('status'),
        );

        $task = $handler->handle($updateTaskCommand);

        return response()->json([
            'task' => $task,
        ], Response::HTTP_OK);
    }

    public function delete(string $id, DeleteTaskCommandHandler $handler): JsonResponse
    {
        $deleteTaskCommand = new DeleteTaskCommand(
            auth()->id(),
            $id,
        );

        $result = $handler->handle($deleteTaskCommand);

        return response()->json([
            'result' => $result,
            'message' => 'Task deleted successfully',
        ], Response::HTTP_OK);
    }
}
