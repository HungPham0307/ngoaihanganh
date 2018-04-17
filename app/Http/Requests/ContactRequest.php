<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            "name" =>"required", //|unique:cat,name
            "email" =>"required|email",
            "title" =>"required",
            "content" =>"required",
          
        ];
    }

    public function messages()
    {
        return [
            "name.required"=>"Vui lòng nhập tên ",
            "email.reqeired" =>"Vui lòng điền email",
            "email.email" =>"Vui lòng nhập đúng định dạng Email",
            "title.required" =>"Vui lòng nhập tiêu đề",
            "content.required" =>"Vui lòng nhập nội dung",
           

        ];
    }
}
