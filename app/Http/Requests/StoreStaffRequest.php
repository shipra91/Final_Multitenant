<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
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
            "staffName" => "required|",
            "staffDob" => "required|",
            "gender" => "required|",
            "staffRoll" => "required|",
            "staffCategory" => "required|",
            "joiningDate" => "required|",
            "staffDob" => "required|",
            "pincode" => "required|",
            "post_office" => "required|",
            "taluk" => "required|",
            "district" => "required|",
            "address" => "required|",
        ];
    }
}
