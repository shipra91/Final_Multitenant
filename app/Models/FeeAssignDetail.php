<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class FeeAssignDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_fee_assign_details';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_fee_assign', 'id_fee_heading', 'action_type', 'installment_no', 'amount', 'due_date', 'remark', 'concession_approved', 'created_by', 'modified_by'
    ];
}