<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class MessageCreditDetails extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_message_credit_details';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_message_credit', 'credit_numbers', 'credit_type', 'amount_received_on', 'amount', 'narration', 'transaction_id', 'created_by', 'modified_by'
    ];
}
