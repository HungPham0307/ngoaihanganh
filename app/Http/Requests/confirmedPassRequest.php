<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class confirmedPassRequest extends FormRequest
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
            "password" =>"required|confirmed|min:6", //|unique:cat,name
           "password_confirmation" =>"required",
           
           
           
        ];
    }

    public function messages()
    {
        return [
            "password.required"=>"Vui lòng nhập pass ",
             "password.min"=>"Vui lòng nhập tổi thiểu 6 kí tự ",
           "password_confirmation.required"=>"Vui lòng nhập xác nhận pass",
            "password.comfirmed"=>"Mật khẩu không trùng",
           
          
        ];
    }
}
