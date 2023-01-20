<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class HolidayApplicableFor extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_holiday_applicable_for';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_holiday', 'applicable_for', 'id_staff_category', 'id_staff_subcategory', 'id_standard', 'created_by', 'modified_by'];
}

