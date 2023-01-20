<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class AdmissionType extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;
    
    protected $table      = 'tbl_admission_type';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'type', 'display_name', 'created_by', 'modified_by'
    ]; 
}
