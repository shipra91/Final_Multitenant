<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class CreateFeeChallan extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_create_fee_challans';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institute', 'id_academic_year', 'id_student', 'id_challan_setting', 'challan_created_by', 'challan_no', 'payment_mode', 'bank_name', 'branch_name', 'account_number', 'ifsc_code', 'transaction_date', 'amount_received', 'sgst', 'cgst', 'gst', 'approved', 'approved_by', 'approved_date', 'bank_transaction_id', 'created_by', 'modified_by'
    ];
}
