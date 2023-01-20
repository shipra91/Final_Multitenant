<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class OrganizationManagement extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use HasFactory;
    use Uuids;
    
    protected $table      = 'tbl_organization_management';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_organization', 'name', 'designation', 'email', 'mobile_number', 'created_by', 'modified_by'
    ];
}
