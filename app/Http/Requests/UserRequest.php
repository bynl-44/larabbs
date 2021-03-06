<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed verification_key
 * @property mixed verification_code
 * @property mixed avatar_image_id
 */
class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|between:3,25|regex:/^[a-zA-Z0-9\-\_]+$/|unique:users,name,' . Auth::id(),
                    'email' => 'required|email',
                    'introduction' => 'max:80',
                    'avatar'=>'mimes:jpeg,png,jpg,gif|dimensions:min_width=208,min_height=208',
                ];
                break;
            case 'PATCH':
                $userId = Auth::guard('api')->id();

                return [
                    'name' => 'between:3,25|regex:/^[a-zA-Z0-9\-\_]+$/|unique:users,name,' . $userId,
                    'email' => 'email',
                    'introduction' => 'max:80',
                    'avatar_image_id' => 'exists:images,id,type,avatar,user_id,' . $userId,
                ];
                break;
        }
    }

    public function messages()
    {
        return [
            'name.unique' => '用户名已被占用，请重新填写',
            'name.regex' => '用户名只支持字母、数字、横杠和下划线',
            'name.between' => '用户名必须介于 3 - 25 个字符之间',
            'name.required' => '用户名不能为空',
            'avatar.mimes'=>'头像必须是 JPEG，PNG，JPG，GIF 格式的图片',
            'avatar.dimensions'=>'头像的清晰度不够，宽和高需要 208px 以上',
        ];
    }
}
