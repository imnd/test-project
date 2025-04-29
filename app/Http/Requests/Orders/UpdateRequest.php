<?php

namespace App\Http\Requests\Orders;

use App\Traits\RequestTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property integer $commodity_id
 * @property integer $user_id
 * @property integer $count
 */
class UpdateRequest extends FormRequest
{
    use RequestTrait;

    public function rules()
    {
        return [
            'commodity_id' => 'nullable|numeric',
            'user_id'      => 'nullable|numeric',
            'count'        => 'nullable|numeric',
        ];
    }
}
