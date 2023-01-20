<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class CategoryFeeHeadingMaster extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_category_fee_heading_masters';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_category_setting', 'id_fee_heading', 'heading_amount', 'collection_priority', 'created_by', 'modified_by'
    ];
}
