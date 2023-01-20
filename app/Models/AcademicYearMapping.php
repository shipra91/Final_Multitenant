<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class AcademicYearMapping extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_academic_year_mappings';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_institute', 'id_academic_year', 'default_year', 'created_by', 'modified_by'];
}
