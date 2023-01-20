<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class CustomFeeAssignment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_custom_fee_assignment';
    protected $primaryKey = 'id';
    protected $fillable   = [  
        'id', 'id_institute', 'id_academic_year', 'id_fee_category', 'id_institution_standard', 'id_student', 'created_by', 'modified_by'
    ];
    
}
