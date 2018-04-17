<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class getPassRequest extends FormRequest
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
            "mail" =>"required|email", //|unique:cat,name
           
           
           
           
        ];
    }

    public function messages()
    {
        return [
            "mail.required"=>"Vui lòng nhập email ",
           "mail.email"=>"Vui lòng nhập đúng định dạng email"
           
          
        ];
    }
}
