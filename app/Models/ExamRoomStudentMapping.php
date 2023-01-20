<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class ExamRoomStudentMapping extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_examroom_student_mapping';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_academic_year', 'id_institute',  'id_examination_room_setting', 'id_student', 'created_by', 'modified_by'
    ];
}
