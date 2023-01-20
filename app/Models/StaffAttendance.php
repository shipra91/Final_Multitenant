<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;


class StaffAttendance extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use Uuids;

    protected $table      = 'tbl_staff_attendances';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_institute', 'id_academic_year', 'id_staff', 'held_on', 'in_time', 'out_time', 'device_id', 'status', 'created_by', 'modified_by'];
}
