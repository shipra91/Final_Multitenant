<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class Organization extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;
    
    protected $table      = 'tbl_organization';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'name', 'type', 'address', 'pincode', 'post_office', 'country', 'state', 'district', 'taluk', 'city', 'office_email', 'mobile_number', 'landline_number', 'poc_name1', 'poc_designation1', 'poc_contact_number1', 'poc_email1', 'poc_name2', 'poc_designation2', 'poc_contact_number2', 'poc_email2', 'poc_name3', 'poc_designation3', 'poc_contact_number3', 'poc_email3', 'website_url', 'gst_number', 'gst_attachment', 'pan_number', 'pan_attachment', 'registration_certificate', 'logo', 'digital_signature','po_signed_date','po_effective_date',  'po_attachment', 'contract_period', 'po_expiry_date', 'yearly_renewal_period', 'created_by', 'modified_by'
    ];
}
