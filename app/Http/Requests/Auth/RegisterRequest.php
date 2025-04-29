<?php

namespace App\Http\Requests\Auth;

use App\Http\Rules\Email;
use App\Traits\RequestTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $email
 * @property string $name
 * @property string $password
 */
class RegisterRequest extends FormRequest
{
    use RequestTrait;

    public function rules()
    {
        return [
            'email'    => ['required', 'unique:users,email,NULL,NULL,deleted_at,NULL', new Email()],
            'name'     => 'required|min:2',
            'password' => 'required|min:8',
        ];
    }
}
