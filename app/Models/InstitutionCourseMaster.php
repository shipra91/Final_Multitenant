<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class InstitutionCourseMaster extends Model implements Auditable
{
     use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_institution_course_master';
    protected $primaryKey = 'id';
    protected $fillable   = [  
        'id',  'id_institute', 'board_university', 'institution_type', 'course', 'stream', 'combination', 'institution_code', 'created_by', 'modified_by'
    ];
}
