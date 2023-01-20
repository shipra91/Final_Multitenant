<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class StaffSubjectMapping extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_staff_subject_mapping';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_academic_year', 'id_staff', 'id_subject', 'created_by', 'modified_by'];

}
