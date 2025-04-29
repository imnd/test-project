<?php

namespace App\Services;

use App\Models\Commodity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CommodityService
{
    public function getList(int $page, int $perPage): LengthAwarePaginator
    {
        return Commodity::query()
            ->paginate(
                perPage: $perPage,
                page: $page,
            );
    }
}
