<?php

namespace App\Commands\Task;


readonly class UpdateTaskCommand
{
    public function __construct(
        public string $userId,
        public string $taskId,
        public ?string $newTitle,
        public ?string $newDescription,
        public ?int $newStatus,
    ) {}
}
