<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class VisitorManagement extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_visitor_management';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_institute', 'id_academic_year', 'type', 'visitor_name', 'visitor_contact', 'visitor_age', 'visitor_address', 'gender', 'person_to_meet', 'concerned_person', 'visit_purpose', 'visitor_type', 'visitor_type_name', 'visiting_datetime', 'end_datetime', 'visiting_status', 'cancellation_reason', 'cancelled_date', 'created_by', 'modified_by'];
}
