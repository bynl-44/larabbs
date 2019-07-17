<?php

namespace App\Http\Requests\Api;

/**
 * @property mixed username
 * @property mixed password
 */
class AuthorizationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string|min:5',
        ];
    }
}
