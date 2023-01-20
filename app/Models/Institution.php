<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class Institution extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_institution';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_organization', 'name', 'address', 'pincode', 'post_office', 'country', 'state', 'district', 'taluk', 'city', 'office_email', 'mobile_number', 'landline_number', 'website_url', 'id_institution_type', 'board', 'university', 'institution_code', 'institution_logo', 'fav_icon', 'sender_id', 'entity_id', 'area_partner_name', 'area_partner_email', 'area_partner_phone', 'zonal_partner_name', 'zonal_partner_email', 'zonal_partner_phone', 'created_by', 'modified_by'
    ];
}
