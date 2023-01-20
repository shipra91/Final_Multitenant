<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Staff extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_staff';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_organization', 'id_academic_year', 'id_institute', 'name', 'middle_name', 'last_name', 'date_of_birth', 'employee_id', 'staff_uid', 'id_gender', 'id_blood_group', 'id_designation', 'id_department', 'id_role', 'id_staff_category', 'id_staff_subcategory', 'primary_contact_no', 'email_id', 'joining_date', 'duration_employment', 'id_nationality', 'id_religion', 'id_caste_category', 'aadhaar_no', 'pancard_no', 'pf_uan_no', 'address', 'city', 'state', 'district', 'taluk', 'pincode', 'post_office', 'country', 'secondary_contact_no', 'staff_image', 'sms_for', 'attachment_aadhaar', 'attachment_pancard', 'head_teacher', 'working_hours', 'created_by', 'modified_by'];
}
