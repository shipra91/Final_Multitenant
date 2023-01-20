<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Student extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_student';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_preadmission', 'name', 'middle_name', 'last_name', 'date_of_birth', 'id_gender', 'egenius_uid', 'usn', 'register_number', 'roll_number', 'admission_date', 'admission_number', 'sats_number', 'student_aadhaar_number', 'id_nationality', 'id_religion', 'caste', 'id_caste_category', 'mother_tongue', 'id_admission_type', 'id_fee_type', 'id_blood_group', 'address', 'city',  'taluk', 'district', 'state','pincode','post_office', 'country', 'father_name', 'father_mobile_number', 'father_profession', 'father_email', 'father_aadhaar_number', 'father_education', 'father_annual_income', 'mother_name', 'mother_mobile_number', 'mother_profession', 'mother_email', 'mother_aadhaar_number', 'mother_education', 'mother_annual_income', 'guardian_name', 'guardian_middle_name', 'guardian_last_name', 'guardian_aadhaar_no', 'guardian_contact_no', 'guardian_email','guardian_relation', 'guardian_address', 'sms_for', 'attachment_student_photo', 'attachment_student_aadhaar', 'attachment_father_aadhaar', 'attachment_mother_aadhaar', 'attachment_father_pancard', 'attachment_mother_pancard', 'attachment_previous_tc', 'attachment_previous_study_certificate', 'created_by', 'modified_by'
    ];
}
