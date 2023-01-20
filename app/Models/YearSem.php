<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class YearSem extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_year_sem_mapping';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institution', 'id_academic_year', 'id_year', 'sem_label', 'from_date', 'to_date', 'created_by', 'modified_by'
    ];
}
