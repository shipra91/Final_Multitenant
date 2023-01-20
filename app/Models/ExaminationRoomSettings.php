<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class ExaminationRoomSettings extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_examination_room_settings';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_academic_year', 'id_institute',  'id_standard', 'id_subject', 'id_exam', 'id_room', 'student_count', 'internal_invigilator', 'external_invigilator', 'created_by', 'modified_by'
    ];
}
