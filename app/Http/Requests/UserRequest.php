<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "username" =>"required", //|unique:cat,name
            "fullname" =>"required",
            "password" =>"required",
            "email" =>"required|email",
        ];
    }

    public function messages()
    {
        return [
            "username.required"=>"Vui lòng nhập tên ",
            "fullname.required"=>"Vui lòng nhập fullname ",
            "password.reqeired" =>"Vui lòng điền mật khẩu",
            "email.reqeired" =>"Vui lòng điền email",
            "email.email" =>"Vui lòng nhập đúng định dạng email",
           
        ];
    }
}
