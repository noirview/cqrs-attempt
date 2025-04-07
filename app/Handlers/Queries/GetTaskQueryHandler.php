<?php

namespace App\Handlers\Queries;

use App\Models\Task;
use App\Queries\Task\GetTaskQuery;

class GetTaskQueryHandler
{
    public function handle(GetTaskQuery $query): Task
    {
        return Task::query()
            ->where([
                'user_id' => $query->userId,
                'id' => $query->taskId
            ])->firstOrFail();
    }
}
