<?php

namespace App\Queries\Task;

readonly class ListTaskQuery
{
    public function __construct(
        public string $userId,
        public ?string $status = null,
    ) {}
}
