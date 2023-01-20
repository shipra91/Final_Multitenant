<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest extends FormRequest
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
            "organization_name" => "required|",       
            "organization_address" => "required|",
            "pincode" => "required|",
            "post_office" => "required|",
            "country" => "required|",
            "state" => "required|",
            "district" => "required|",
            "taluk" => "required|",
            "city" => "required|",
            "office_email_id" => "required|",
            "office_mobile_number" => "required|",
            "management_name" => "required|",
            "management_designation" => "required|",
            "management_phoneNumber" => "required|",
            "management_email_id" => "required|",
            "poc_name1" => "required|",
            "poc_designation1" => "required|",
            "poc_phoneNumber1" => "required|",
            "poc_email_Id1" => "required|",
            "po_signed_date" => "required|",
            "po_effective_date" => "required|",
            "contract_period" => "required|",
            "po_attachment" => "required|",
            "organization_logo" => "required|",
        ];
    }
}
