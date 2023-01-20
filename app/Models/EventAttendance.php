<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;


class EventAttendance extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_event_attendance';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_event', 'recipient_type', 'id_recipient', 'attendance_status', 'created_by', 'modified_by'
    ];
}
