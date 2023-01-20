<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;


class PaymentGatewayFields extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_payment_gateway_field';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_payment_gateway', 'field_label', 'field_key', 'created_by', 'modified_by'
    ];
}
