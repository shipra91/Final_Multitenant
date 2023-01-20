<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class PreadmissionCustom extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use Uuids;
    
    protected $table      = 'tbl_preadmission_custom';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_preadmission', 'id_custom_field', 'field_value','created_by', 'modified_by'
    ];

}
