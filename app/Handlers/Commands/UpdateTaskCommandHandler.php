<?php

namespace App\Handlers\Commands;

use App\Commands\Task\UpdateTaskCommand;
use App\Events\Task\TaskUpdatedEvent;
use App\Models\Task;

class UpdateTaskCommandHandler
{
    public function handle(UpdateTaskCommand $command): Task
    {
        Task::query()
            ->where('user_id', $command->userId)
            ->where('id', $command->taskId)
            ->update([
                'title' => $command->newTitle,
                'description' => $command->newDescription,
                'status' => $command->newStatus,
            ]);

        $task = Task::query()->findOrFail($command->taskId);

        event(new TaskUpdatedEvent($task));

        return $task;
    }
}
