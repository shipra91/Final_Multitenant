<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class AssignmentSubmissionPermission extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_assignment_submission_permission';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_assignment', 'id_student', 'resubmission_allowed', 'resubmission_date', 'resubmission_time', 'created_by', 'modified_by'
    ];
}
