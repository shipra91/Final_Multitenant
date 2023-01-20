<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class Project extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_project';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institute', 'id_academic', 'id_standard', 'id_subject', 'id_staff', 'name', 'start_date', 'end_date', 'description', 'chapter_name', 'start_time', 'end_time', 'submission_type', 'grading_required', 'grading_option', 'grade', 'marks', 'read_receipt', 'sms_alert', 'created_by', 'modified_by'
    ];
}
