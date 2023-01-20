<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class StaffCustomDetails extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_staff_custom_details';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_staff', 'id_custom_field', 'field_value', 'created_by', 'modified_by'];
}
