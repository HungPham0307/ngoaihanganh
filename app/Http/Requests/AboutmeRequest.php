<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutmeRequest extends FormRequest
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
            "noidung" =>"required", //|unique:cat,name
           
           
           
           
        ];
    }

    public function messages()
    {
        return [
            "noidung.required"=>"Vui lòng nhập nội dung ",
            
           
          
        ];
    }
}
