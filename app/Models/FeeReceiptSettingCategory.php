<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class FeeReceiptSettingCategory extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_fee_receipt_setting_categories';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_fee_receipt_settings', 'id_fee_category', 'created_by', 'modified_by'
    ];
}
