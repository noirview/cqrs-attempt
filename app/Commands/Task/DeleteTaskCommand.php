<?php

namespace App\Commands\Task;

readonly class DeleteTaskCommand
{
    public function __construct(
        public string $userId,
        public string $taskId,
    ) {}
}
