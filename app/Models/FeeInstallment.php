<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class FeeInstallment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_fee_installment';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_fee_assign', 'installment_no', 'amount', 'percentage', 'due_date', 'created_by', 'modified_by'
    ];
}
