<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            "tenduan" =>"required", //|unique:cat,name
            "mota" =>"required",
            "link" =>"required",
           
           
           
        ];
    }

    public function messages()
    {
        return [
            "tenduan.required"=>"Vui lòng nhập tên dự án ",
            "mota.reqeired"=>"Vui lòng điền nội dung",
            "link.reqeired"=>"Vui lòng nhập link dự án",
           
          
        ];
    }
}
