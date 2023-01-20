<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class CustomFeeAssignHeading extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_custom_fee_assign_heading';
    protected $primaryKey = 'id';
    protected $fillable   = [  
        'id', 'id_custom_fee_assign', 'id_heading', 'amount', 'no_of_installment', 'installment_type', 'created_by', 'modified_by'
    ];
    
}

