<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class FeeAssignSetting extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_fee_assign_setting';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id' ,'id_fee_master', 'id_fee_heading', 'no_of_installment', 'installment_type', 'amount', 'created_by', 'modified_by'
    ];
}
