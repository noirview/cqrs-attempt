<?php

namespace App\Http\Controllers;

use App\Commands\Task\CreateTaskCommand;
use App\Commands\Task\DeleteTaskCommand;
use App\Commands\Task\UpdateTaskCommand;
use App\Handlers\Commands\CreateTaskCommandHandler;
use App\Handlers\Commands\DeleteTaskCommandHandler;
use App\Handlers\Commands\UpdateTaskCommandHandler;
use App\Handlers\Queries\GetTaskQueryHandler;
use App\Handlers\Queries\ListTaskQueryHandler;
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
            (string)auth()->id(),
            $request->string('status'),
        );

        $tasks = $handler->handle($indexTaskQuery);

        return response()->json([
            'tasks' => $tasks->items(),
        ], Response::HTTP_OK);
    }

    public function store(StoreRequest $request, CreateTaskCommandHandler $handler): JsonResponse
    {
        $createTaskCommand = new CreateTaskCommand(
            (string)auth()->id(),
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
            (string)auth()->id(),
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
            (string)auth()->id(),
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
            (string)auth()->id(),
            $id,
        );

        $result = $handler->handle($deleteTaskCommand);

        return response()->json([
            'result' => $result,
            'message' => 'Task deleted successfully',
        ], Response::HTTP_OK);
    }
}
