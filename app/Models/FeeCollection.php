<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class FeeCollection extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_fee_collections';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institute', 'id_academic_year', 'id_student', 'collected_by', 'paid_date', 'payment_mode', 'receipt_prefix', 'receipt_no', 'id_receipt_setting', 'transaction_no', 'bank_name', 'branch_name', 'transaction_date', 'amount_received', 'sgst', 'cgst', 'gst', 'total_fine_amount', 'orderId_online', 'cancelled', 'cancelled_by', 'cancelled_date', 'cancellation_remarks', 'remarks', 'created_by', 'modified_by', 'deleted_at'
    ];
}