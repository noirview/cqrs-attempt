<?php

namespace App\Handlers\Queries;

use App\Models\Task;
use App\Queries\Task\ListTaskQuery;
use Illuminate\Contracts\Pagination\Paginator;

class ListTaskQueryHandler
{
    /**
     * @param ListTaskQuery $query
     * @return Paginator<int, Task>
     */
    public function handle(ListTaskQuery $query): Paginator
    {
        return Task::query()
            ->where('user_id', $query->userId)
            ->when($query->status,
                fn($queryBuilder) => $queryBuilder->where('status', $query->status)
            )->paginate(10);
    }
}
