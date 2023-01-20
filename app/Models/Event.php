<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;


class Event extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use HasFactory;
    use Uuids;

    protected $table      = 'tbl_event';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_institute', 'id_academic', 'name', 'start_date', 'end_date', 'start_time', 'end_time', 'event_detail', 'event_type', 'attendance_required', 'receipt_required', 'created_by', 'modified_by'];
}
