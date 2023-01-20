<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class Circular extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use HasFactory;
    use Uuids;

    protected $table      = 'tbl_circular';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_institute', 'id_academic', 'circular_title', 'start_date', 'end_date', 'description', 'receipt_required', 'sms_alert', 'created_by', 'modified_by'];
}
