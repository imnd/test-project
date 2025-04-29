<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderService
{
    public function getList(int $page, int $perPage): LengthAwarePaginator
    {
        return Order::query()
            ->paginate(
                perPage: $perPage,
                page: $page,
            );
    }
}
