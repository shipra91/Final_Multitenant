<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class FeeAssign extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_fee_assign';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_organization', 'id_institution', 'id_academic', 'id_standard', 'id_student', 'id_fee_category', 'id_fee_type', 'total_amount', 'installment_type', 'created_by', 'modified_by'
    ];
}