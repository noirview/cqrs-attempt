<?php

namespace App\Handlers;

use App\Models\Task;
use App\Queries\Task\ListTaskQuery;
use Illuminate\Contracts\Pagination\Paginator;

class ListTaskQueryHandler
{
    public function handle(ListTaskQuery $query): Paginator
    {
        return Task::query()
            ->where('user_id', $query->userId)
            ->when($query->status,
                fn($query) => $query->where('status', $query->status)
            )->paginate(10);
    }
}
