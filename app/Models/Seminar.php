<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class Seminar extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use HasFactory;
    use Uuids;

    protected $table      = 'tbl_seminar';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_institute', 'id_academic', 'seminar_topic', 'start_date', 'end_date', 'start_time', 'end_time', 'max_marks', 'description', 'sms_alert', 'created_by', 'modified_by'];
}
