<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class ExamSubjectConfiguration extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_exam_subject_configuration';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institute', 'id_academic', 'id_exam', 'id_standard', 'id_subject', 'id_grade_set', 'display_name', 'subject_part', 'priority', 'conversion', 'conversion_value', 'max_mark', 'pass_mark', 'created_by', 'modified_by'
    ];
}
