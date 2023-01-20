<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;


class PeriodSettings extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use Uuids;

    protected $table      = 'tbl_period_setting';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_institute', 'id_academic', 'id_standard', 'days', 'no_of_teaching_periods', 'no_of_break_periods', 'time_interval', 'created_by', 'modified_by'];

}
