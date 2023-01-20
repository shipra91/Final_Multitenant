<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class StudentMapping extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory;
    use SoftDeletes;
    use Uuids;
    
    protected $table      = 'tbl_student_mapping';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_student', 'id_standard', 'id_organization', 'id_institute', 'id_academic_year', 'id_first_language', 'id_second_language', 'id_third_language', 'id_elective', 'id_admission_type', 'id_fee_type', 'created_by', 'modified_by'
    ];
}
