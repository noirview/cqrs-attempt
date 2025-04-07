<?php

namespace App\Commands\Task;

readonly class CreateTaskCommand
{
    public function __construct(
        public string $userId,
        public string $title,
        public string $description,
    ) {}
}
