<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class ComposeMessage extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_message_center';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institute', 'id_academic', 'id_institution_sms_templates', 'description', 'message_to', 'sender_id', 'message_date_time', 'created_by', 'modified_by'
    ];
}
