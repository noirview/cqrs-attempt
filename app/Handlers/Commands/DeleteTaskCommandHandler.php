<?php

namespace App\Handlers\Commands;

use App\Commands\Task\DeleteTaskCommand;
use App\Events\Task\TaskDeletedEvent;
use App\Models\Task;

class DeleteTaskCommandHandler
{
    public function handle(DeleteTaskCommand $command): bool
    {
        $task = Task::query()->findOrFail($command->taskId);

        $result = $task->delete();

        event(new TaskDeletedEvent($task));

        return $result;
    }
}
