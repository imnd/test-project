<?php

namespace App\Http\Requests\Commodities;

use App\Traits\RequestTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property string $description
 * @property string $price
 */
class UpdateRequest extends FormRequest
{
    use RequestTrait;

    public function rules()
    {
        return [
            'name'    => 'nullable|string',
            'description' => 'nullable|string',
            'price'   => 'nullable|numeric',
        ];
    }
}
