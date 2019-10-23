<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Validate the given request with the given rules.
     *
     * @param  $data
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return array
     *
     * @throws ValidationException
     */
    public function validate($data, array $rules, array $messages = [], array $customAttributes = [])
    {
        if ($data instanceof Request) {
            $data = $data->all();
        }
        $validator = $this->getValidationFactory()->make($data, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->throwValidationException($validator);
        }
    }

    /**
     * Throw the failed validation exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws ValidationException
     */
    protected function throwValidationException($validator)
    {
        throw new ValidationException(
            $validator,
            new JsonResponse(['errors'=>$validator->errors()->getMessages()], 422)
        );
    }
}
