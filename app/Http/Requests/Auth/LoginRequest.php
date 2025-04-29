<?php

namespace App\Http\Requests\Auth;

use App\Http\Rules\Email;
use App\Traits\RequestTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $email
 * @property string $password
 */
class LoginRequest extends FormRequest
{
    use RequestTrait;

    public function rules()
    {
        return [
            'email' => ['required', new Email()],
            'password' => 'required',
        ];
    }
}
