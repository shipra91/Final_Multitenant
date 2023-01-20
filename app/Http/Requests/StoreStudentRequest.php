<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "date_of_birth" => "required|",
            "gender" => "required|",
            "standard" => "required|",
            "nationality" => "required|",
            "religion" => "required|",
            "caste" => "required|",
            "student_pincode" => "required|",
            "student_post_office" => "required|",
            "student_taluk" => "required|",
            "student_district" => "required|",
            "student_address" => "required|",
            "father_mobile_number" => "required|",
            "mother_mobile_number" => "required|",
        ];
    }
}
