<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class AttendanceSettings extends Model implements Auditable   
{
    use HasFactory;
        use \OwenIt\Auditing\Auditable;
        use SoftDeletes;
        use Uuids;

        protected $table      = 'tbl_attendance_settings';
        protected $primaryKey = 'id';
        protected $fillable   = [
<<<<<<< HEAD
            'id','id_institute', 'id_academic', 'attendance_type', 'id_standard', 'id_template', 'display_subject', 'is_subject_classtimetable_dependent', 'created_by', 'modified_by'
=======
            'id', 'attendance_type', 'id_standard', 'id_template', 'display_subject', 'is_subject_classtimetable_dependent', 'created_by', 'modified_by'
>>>>>>> main
        ];
}
