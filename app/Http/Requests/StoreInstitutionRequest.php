<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstitutionRequest extends FormRequest
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
            "organizationName" => "required|",
            "institutionName" => "required|",
            "institutionAddress" => "required|",
            "pincode" => "required|",
            "postOffice" => "required|",
            "district" => "required|",
            "taluk" => "required|",
            // "institution_type" => "required|",
            // "board_university" => "required|",
            "modules" => "required|",
            "areaPartnerName" => "required|",
            "areaPartnerEmail" => "required|",
            "areaPartnerContact" => "required|",
            "zonalPartnerName" => "required|",
            "zonalPartnerEmail" => "required|",
            "zonalPartnerContact" => "required|",
        ];
    }
}
