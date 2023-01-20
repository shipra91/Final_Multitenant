<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class StandardSubject extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;
    use \OwenIt\Auditing\Auditable;

    protected $table      = 'tbl_standard_subject';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institute', 'id_academic_year', 'id_standard', 'id_institution_subject', 'display_name', 'created_by', 'modified_by'
    ];
}
