<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class Preadmission extends Model implements Auditable {

    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_preadmission';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institute', 'id_academic_year', 'type', 'application_number', 'name', 'middle_name', 'last_name', 'id_standard', 'date_of_birth', 'id_gender', 'student_aadhaar_number', 'id_nationality', 'id_religion', 'caste', 'id_caste_category', 'mother_tongue', 'id_blood_group', 'address', 'city', 'taluk', 'district', 'state', 'country', 'pincode', 'post_office', 'father_name', 'father_middle_name', 'father_last_name', 'father_mobile_number', 'father_aadhaar_number', 'father_education', 'father_profession', 'father_email', 'father_annual_income', 'mother_name', 'mother_middle_name', 'mother_last_name', 'mother_mobile_number', 'mother_aadhaar_number', 'mother_education', 'mother_profession', 'mother_email', 'mother_annual_income', 'guardian_name', 'guardian_middle_name', 'guardian_last_name', 'guardian_aadhaar_no', 'guardian_contact_no', 'guardian_email', 'guardian_relation', 'guardian_address', 'sms_for', 'attachment_student_photo', 'attachment_student_aadhaar', 'attachment_father_aadhaar', 'attachment_mother_aadhaar', 'attachment_father_pancard', 'attachment_mother_pancard', 'attachment_previous_tc', 'attachment_previous_study_certificate', 'admitted', 'application_status', 'remarks', 'created_by', 'modified_by'
    ];
}
