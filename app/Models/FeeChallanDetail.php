<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class FeeChallanDetail extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_fee_challan_details';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_fee_challan', 'id_fee_category', 'id_fee_mapping_heading', 'installment_no', 'fee_amount', 'sgst_received', 'cgst_received', 'gst_received', 'created_by', 'modified_by'
    ];
}
