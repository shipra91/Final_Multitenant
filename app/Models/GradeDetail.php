<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class GradeDetail extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_grade_detail';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_grade', 'grade_name', 'range_from', 'range_to', 'remark', 'avg_point', 'created_by', 'modified_by'
    ];
}
