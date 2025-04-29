<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     @OA\Xml(name="OrderResource"),
 *     @OA\Property(property="id", type="integer", example="30299"),
 *     @OA\Property(property="commodity", type="object", @OA\Schema (ref="#/components/schemas/CommodityResource")),
 *     @OA\Property(property="count", type="integer", example="100"),
 *     @OA\Property(property="cost", type="integer", example="15000"),
 *     @OA\Property(property="price", type="integer", example="150"),
 *     @OA\Property(property="user", type="object", @OA\Schema (ref="#/components/schemas/UserResource")),
 * )
 */
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'commodity' => $this->commodity->name,
            'price' => $this->commodity->price,
            'cost' => $this->commodity->price * $this->count,
            'count'     => $this->count,
            'user'      => $this->user->name,
        ];
    }
}
