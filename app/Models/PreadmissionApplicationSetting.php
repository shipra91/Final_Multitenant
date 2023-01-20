<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class PreadmissionApplicationSetting extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;
    
    protected $table      = 'tbl_preadmission_application_settings';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_academic', 'id_institution', 'name', 'prefix', 'starting_number', 'standards', 'created_by', 'modified_by'
    ];
}