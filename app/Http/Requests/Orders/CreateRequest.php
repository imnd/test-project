<?php

namespace App\Http\Requests\Orders;

use App\Traits\RequestTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property integer $commodity_id
 * @property integer $user_id
 * @property integer $count
 */
class CreateRequest extends FormRequest
{
    use RequestTrait;

    public function rules()
    {
        return [
            'commodity_id' => ['required', 'exists:commodities,id,deleted_at,NULL'],
            'user_id'      => ['required', 'numeric', 'exists:users,id'],
            'count'        => 'required|numeric',
        ];
    }
}
