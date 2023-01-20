<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class Module extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_module';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'module_label', 'display_name', 'id_parent', 'file_path', 'icon', 'page', 'type', 'is_custom_field_required', 'is_sms_mapped', 'is_email_mapped', 'created_by', 'modified_by'
    ];
}
