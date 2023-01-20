<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class MessageReport extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_message_report';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institute', 'id_academic', 'id_message_center', 'message_type', 'sender_id', 'recipient_type', 'id_recipient', 'recipient_number', 'sms_track_id', 'sms_message_id', 'sms_vendor', 'sms_description', 'sms_sent_at', 'sms_delivered_at', 'sent_status', 'sms_charge', 'completed', 'created_by', 'modified_by'
    ];
}
