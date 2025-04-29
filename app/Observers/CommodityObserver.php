<?php

namespace App\Observers;

use App\Models\Commodity;

class CommodityObserver
{
    /**
     * Handle the Commodity "deleted" event.
     */
    public function deleted(Commodity $commodity): void
    {
        $commodity->orders()->delete();
    }
}
