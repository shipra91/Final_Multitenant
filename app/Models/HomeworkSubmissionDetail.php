<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class HomeworkSubmissionDetail extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_homework_submission_details';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_homework_submission', 'submitted_file', 'created_by', 'modified_by'
    ];
}
