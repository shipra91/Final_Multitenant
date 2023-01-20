<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;


class ProjectSubmission extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_project_submission';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_project', 'id_student', 'submitted_file', 'obtained_marks', 'comments', 'submitted_date', 'submitted_time', 'created_by', 'modified_by'
    ];
}
