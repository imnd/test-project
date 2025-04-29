<?php

namespace App\Http\Requests\Commodities;

use App\Traits\RequestTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property string $description
 * @property string $price
 */
class CreateRequest extends FormRequest
{
    use RequestTrait;

    public function rules()
    {
        return [
            'name'    => 'required|string',
            'description' => 'required|string',
            'price'   => 'required|numeric',
        ];
    }
}
