<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait RequestTrait
{
    protected function failedValidation(Validator $validator)
    {
        $exception = $validator->messages();

        throw new HttpException(422, json_encode($exception->getMessages()));
    }
}
