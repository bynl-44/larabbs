<?php

namespace App\Http\Requests\Api;

/**
 * @property mixed social_type
 * @property mixed code
 * @property mixed access_token
 *“ @property mixed openid
 */
class socialAuthorizationRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'code' => 'required_without:access_token|string',
            'access_token' => 'required_without:code|string',
        ];

        if ($this->social_type == 'weixin' && !$this->code) {
            $rules['openid'] = 'required|string';
        }
        return $rules;
    }
}
