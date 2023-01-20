<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class CourseMaster extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_course_master';
    protected $primaryKey = 'id';
    protected $fillable   = [  
        'id', 'board_university', 'institution_type', 'course', 'stream', 'combination', 'created_by', 'modified_by'
    ];
    
}
