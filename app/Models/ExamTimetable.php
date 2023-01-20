<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class ExamTimetable extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_exam_timetable';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_exam_timetable_setting', 'id_institution_subject', 'exam_date', 'duration_in_min', 'start_time', 'end_time', 'max_marks', 'min_marks','created_by', 'modified_by'
    ];
}
