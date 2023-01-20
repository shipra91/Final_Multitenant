<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class InstitutionSmsTemplates extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_institution_sms_templates';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institute', 'module_name', 'sms_for', 'sender_id', 'sms_template_id', 'status', 'created_by', 'modified_by', 'deleted_at'
    ];
}
