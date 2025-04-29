<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     @OA\Xml(name="CommodityResource"),
 *     @OA\Property(property="id", type="integer", example="30299"),
 *     @OA\Property(property="name", type="string", example="Rubber woman"),
 *     @OA\Property(property="description", type="string", example="UYT7778L"),
 *     @OA\Property(property="price", type="integer", example="15000"),
 * )
 */
class CommodityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'description' => $this->description,
            'price'   => $this->price,
        ];
    }
}
