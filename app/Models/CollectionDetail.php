<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class CollectionDetail extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_fee_collection_details';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_fee_collection', 'id_fee_category', 'id_fee_mapping_heading', 'installment_no', 'fee_amount', 'sgst_received', 'cgst_received', 'gst_received', 'fine_amount', 'created_by', 'modified_by', 'deleted_at'
    ];
}