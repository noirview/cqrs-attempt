<?php

namespace App\Queries\Task;

readonly class GetTaskQuery
{
    public function __construct(
        public string $userId,
        public string $taskId,
    ) {}
}
