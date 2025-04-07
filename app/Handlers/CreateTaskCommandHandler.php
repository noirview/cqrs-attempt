<?php

namespace App\Handlers;

use App\Commands\Task\CreateTaskCommand;
use App\Enums\TaskStatus;
use App\Events\Task\TaskCreatedEvent;
use App\Models\Task;

class CreateTaskCommandHandler
{
    public function handle(CreateTaskCommand $command): Task
    {
        $task = Task::query()->create([
            'user_id' => $command->userId,
            'title' => $command->title,
            'description' => $command->description,
            'status' => TaskStatus::TODO,
        ]);

        event(new TaskCreatedEvent($task));

        return $task;
    }
}
