<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class PaymentGatewayValues extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_payment_gateway_values';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_payment_gateway_settings', 'id_gateway_fields', 'field_value', 'created_by', 'modified_by'
    ];
}
