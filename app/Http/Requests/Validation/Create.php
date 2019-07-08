<?php

namespace App\Http\Requests\Validation;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /**
            return false;   //所有的请求都不能通过验证
            return \Auth::id() === 1 ? true : false;  //只允许id=1的用户执行
         */

        return true;   // 不需要验证身份, 直接返回true
    }

    /**
     * Get the validation rules that apply to the request.
     *各种验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tag' => 'required',
            'name'=>'required|string|max:10',
            'email'=>"required|string|email|max:255|unique:users",
            'password' => 'required|string|min:6|confirmed'
        ];
    }
}
