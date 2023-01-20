<?php 
    namespace App\Services;
    use App\Models\Organization;
    use App\Services\OrganizationManagementService;
    use App\Repositories\OrganizationRepository;
    use App\Models\OrganizationManagement;
    use App\Repositories\DesignationRepository;
    use App\Repositories\InstitutionRepository;
    use App\Models\Designation;
    use Carbon\Carbon;
    use Session;
    use DB;

    class OrganizationService {

        public function all()
        {
            $organizationRepository = new OrganizationRepository();
            $organization = $organizationRepository->all();
            return $organization;        
        }      

        public function find($id){

            $designationRepository = new DesignationRepository();
            $organizationRepository = new OrganizationRepository();
            $organization = $organizationRepository->fetch($id);
            $organization['poc_designation_name1'] = $organization['poc_designation_name2'] = $organization['poc_designation_name3'] = '';

            if($organization['poc_designation1'] != '')
            {
                $pocDesignationName1 = $designationRepository->fetch($organization['poc_designation1']);
                if($pocDesignationName1){
                    $organization['poc_designation_name1'] = $pocDesignationName1->name;
                }                
            }


            if($organization['poc_designation2'] != '')
            {
                $pocDesignationName2 = $designationRepository->fetch($organization['poc_designation2']);
                if($pocDesignationName2){
                    $organization['poc_designation_name2'] = $pocDesignationName2->name;
                }                
            }
            
            if($organization['poc_designation3'] != '')
            {
                $pocDesignationName3 = $designationRepository->fetch($organization['poc_designation3']);
                if($pocDesignationName3){
                    $organization['poc_designation_name3'] = $pocDesignationName3->name;
                }
            }

            return $organization;
        }
    
        public function add($organizationData){
            $organizationManagementService = new OrganizationManagementService();
            $designationRepository = new DesignationRepository();
            $organizationRepository = new OrganizationRepository();
            $check = Organization::where('name', $organizationData->organization_name)->first();
            if(!$check){

                $landlineNumber = 0;
                $websiteUrl = $gstNumber = $panNumber = $contractPeriod = $gstAttachment = $panAttachment = $registrationAttachment = $organizationLogo = $poAttachment =  $pocDesignation1 =  $pocDesignation2 =  $pocDesignation3 = $pocDesignationId1 =  $pocDesignationId2 =  $pocDesignationId3 = '';

                $baseFilePath = 'egenius_multitenant-s3/'.$organizationData->organization_name.'/attachments';

                $poSignedDate = Carbon::createFromFormat('d/m/Y', $organizationData->po_signed_date)->format('Y-m-d');
                $poEffectiveDate = Carbon::createFromFormat('d/m/Y', $organizationData->po_effective_date)->format('Y-m-d');
                $expiryPoDate = Carbon::createFromFormat('d/m/Y', $organizationData->expiry_po_date)->format('Y-m-d');
                $renewalPeriod = Carbon::createFromFormat('d/m/Y', $organizationData->renewal_period)->format('Y-m-d');

                if($organizationData->landline_number !=''){
                    $landlineNumber = $organizationData->landline_number;
                }

                if($organizationData->website_url !='')
                {
                    $url = preg_replace("(^https?://)", "", $organizationData->website_url);
                    $webUrl = explode("/", $url);

                    $websiteUrl = $webUrl[0];
                }

                if($organizationData->gst_number !='')
                {
                    $gstNumber = $organizationData->gst_number;
                }

                if($organizationData->pan_number !='')
                {
                    $panNumber = $organizationData->pan_number;
                }

                // s3 file upload function call
                if($organizationData->hasfile('organization_logo'))
                {
                    $organizationLogo = $organizationRepository->upload($organizationData->organization_logo, $baseFilePath);
                }

                if($organizationData->hasfile('gst_attachment'))
                {
                    $gstAttachment = $organizationRepository->uploadOtherFiles($organizationData->gst_attachment, $baseFilePath);
                }

                if($organizationData->hasfile('pan_attachment'))
                {
                    $panAttachment = $organizationRepository->uploadOtherFiles($organizationData->pan_attachment, $baseFilePath);
                }

                if($organizationData->hasfile('registration_attachment'))
                {
                    $registrationAttachment = $organizationRepository->uploadOtherFiles($organizationData->registration_attachment, $baseFilePath);
                }

                if($organizationData->hasfile('po_attachment'))
                {
                    $poAttachment = $organizationRepository->uploadOtherFiles($organizationData->po_attachment, $baseFilePath);
                }

                if($organizationData->poc_designation1 !='')
                {
                    $pocDesignation1 = $organizationData->poc_designation1;

                    if($organizationData->poc_designation_id1 !='')
                    {
                        $pocDesignationId1 = $organizationData->poc_designation_id1;

                    }else{

                        $check = Designation::where('name', 'LIKE %'.$organizationData->designation1.'%')->first();

                        if(!$check)
                        {
                            $data = array(
                            'name' => $pocDesignation1,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                            );
                            $storeDesignation = $designationRepository->store($data);
                            $pocDesignationId1 = $storeDesignation->id;
                        }
                        else
                        {
                            $pocDesignationId1 = $check->id;
                        }
                    }
                }

                if($organizationData->poc_designation2 !='')
                {
                     $pocDesignation2 = $organizationData->poc_designation2;

                    if($organizationData->poc_designation_id2 !='')
                    {
                        $pocDesignationId2 = $organizationData->poc_designation_id2;

                    }else{

                        $check = Designation::where('name', 'LIKE %'.$organizationData->designation2.'%')->first();

                        if(!$check)
                        {
                            $data = array(
                            'name' => $pocDesignation2,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                            );
                            $storeDesignation = $designationRepository->store($data);
                            $pocDesignationId2 = $storeDesignation->id;
                        }
                        else
                        {
                            $pocDesignationId2 = $check->id;
                        }
                    }
                }

                if($organizationData->poc_designation3 !='')
                {
                    $pocDesignation3 = $organizationData->poc_designation3;

                    if($organizationData->poc_designation_id3 !='')
                    {
                        $pocDesignationId3 = $organizationData->poc_designation_id3;

                    }else{

                        $check = Designation::where('name', 'LIKE %'.$organizationData->designation3.'%')->first();

                        if(!$check)
                        {
                            $data = array(
                            'name' => $pocDesignation3,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                            );
                            $storeDesignation = $designationRepository->store($data);
                            $pocDesignationId3 = $storeDesignation->id;
                        }
                        else
                        {
                            $pocDesignationId3 = $check->id;
                        }
                    }
                }

                $data = array(
                    'name' => $organizationData->organization_name, 
                    'address' => $organizationData->organization_address, 
                    'pincode' => $organizationData->pincode,  
                    'post_office' => $organizationData->post_office, 
                    'country' => $organizationData->country,  
                    'state' => $organizationData->state,  
                    'district' => $organizationData->district,  
                    'taluk' => $organizationData->taluk,  
                    'city' => $organizationData->city,  
                    'office_email' => $organizationData->office_email_id,  
                    'mobile_number' => $organizationData->office_mobile_number,  
                    'landline_number' => $landlineNumber,  
                    'poc_name1' => $organizationData->poc_name1, 
                    'poc_designation1' => $pocDesignationId1,   
                    'poc_contact_number1' => $organizationData->poc_phoneNumber1, 
                    'poc_email1' => $organizationData->poc_email_Id1, 
                    'poc_name2' => $organizationData->poc_name2,
                    'poc_designation2' => $pocDesignationId2,   
                    'poc_contact_number2' => $organizationData->poc_phoneNumber2, 
                    'poc_email2' => $organizationData->poc_email_Id2, 
                    'poc_name3' => $organizationData->poc_name3, 
                    'poc_designation3' => $pocDesignationId3,   
                    'poc_contact_number3' => $organizationData->poc_phoneNumber3, 
                    'poc_email3' => $organizationData->poc_email_Id3,
                    'website_url' => $websiteUrl, 
                    'gst_number' => strtoupper($gstNumber), 
                    'gst_attachment' => $gstAttachment, 
                    'pan_number' => strtoupper($panNumber), 
                    'pan_attachment' => $panAttachment, 
                    'registration_certificate' => $registrationAttachment,
                    'logo' => $organizationLogo, 
                    'po_signed_date' => $poSignedDate, 
                    'po_effective_date' => $poEffectiveDate, 
                    'po_attachment' => $poAttachment,
                    'contract_period' => $organizationData->contract_period,
                    'po_expiry_date' => $expiryPoDate,
                    'yearly_renewal_period' => $renewalPeriod,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );
                $response = $organizationRepository->store($data);
                if($response)
                {  
                    $lastInsertedId = $response->id;
                    $managementResponse = $organizationManagementService->add($organizationData, $lastInsertedId );
                    if($managementResponse)
                    {
                        $signal = 'success';
                        $msg = 'Data inserted successfully!';
                    }
                    else
                    {
                        $signal = 'failure';
                        $msg = 'Error inserting in management data!';
                    }
                   
                }
                else
                {
                    $signal = 'failure';
                    $msg = 'Error inserting data!';
                } 
            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            } 
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function update($organizationData, $id){

            $organizationManagementService = new OrganizationManagementService();
            $designationRepository = new DesignationRepository();
            $organizationRepository = new OrganizationRepository();
            $websiteUrl = $gstNumber = $panNumber = $contractPeriod = $gstAttachment = $panAttachment = $registrationAttachment = $organizationLogo = $poAttachment =   $pocDesignation1 =  $pocDesignation2 =  $pocDesignation3 = $pocDesignationId1 =  $pocDesignationId2 =  $pocDesignationId3 =   $pocDesignation1 =  $pocDesignation2 =  $pocDesignation3 = $pocDesignationId1 =  $pocDesignationId2 =  $pocDesignationId3 = '';

            $baseFilePath = 'egenius_multitenant-s3/'.$organizationData->organization_name.'/attachments';

            $poSignedDate = Carbon::createFromFormat('d/m/Y', $organizationData->po_signed_date)->format('Y-m-d');
            $poEffectiveDate = Carbon::createFromFormat('d/m/Y', $organizationData->po_effective_date)->format('Y-m-d');
            $expiryPoDate = Carbon::createFromFormat('d/m/Y', $organizationData->expiry_po_date)->format('Y-m-d');
            $renewalPeriod = Carbon::createFromFormat('d/m/Y', $organizationData->renewal_period)->format('Y-m-d');

            $check = Organization::where('name', $organizationData->organization_name)->where('id', '!=', $id)->first();
            if(!$check)
            {
                if($organizationData->landline_number !='')
                {
                    $landlineNumber = $organizationData->landline_number;
                }
                else
                {
                    $landlineNumber = 0;
                }

                // s3 file upload function call
                if($organizationData->hasfile('gst_attachment'))
                {
                    $gstAttachment = $organizationRepository->uploadOtherFiles($organizationData->gst_attachment, $baseFilePath);
                }
                else
                {
                    $gstAttachment = $organizationData->old_gst_attachment;
                }

                if($organizationData->hasfile('pan_attachment'))
                {
                    $panAttachment = $organizationRepository->uploadOtherFiles($organizationData->pan_attachment, $baseFilePath);
                }
                else
                {
                    $panAttachment = $organizationData->old_pan_attachment;
                }

                if($organizationData->hasfile('registration_attachment'))
                {
                    $registrationAttachment = $organizationRepository->uploadOtherFiles($organizationData->registration_attachment, $baseFilePath);
                }
                else
                {
                    $registrationAttachment = $organizationData->old_registration_attachment;
                }

                if($organizationData->hasfile('organization_logo'))
                {
                    $organizationLogo = $organizationRepository->upload($organizationData->organization_logo, $baseFilePath);
                }
                else
                {
                    $organizationLogo = $organizationData->old_organization_logo;
                }

                if($organizationData->hasfile('po_attachment'))
                {
                    $poAttachment = $organizationRepository->uploadOtherFiles($organizationData->po_attachment, $baseFilePath);
                }
                else
                {
                    $poAttachment =  $organizationData->old_po_attachment;
                }

                
                if($organizationData->poc_designation1 !='')
                {
                    $pocDesignation1 = $organizationData->poc_designation1;
                    $check = Designation::where('name', 'LIKE', $organizationData->poc_designation1)->first();

                    if($check){

                        $pocDesignationId1 = $check->id;
                        
                    }else{
                        
                        $data = array(
                            'name' => $pocDesignation1,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );
                        $storeDesignation = $designationRepository->store($data);
                        $pocDesignationId1 = $storeDesignation->id;

                    }
                }

                if($organizationData->poc_designation2 !='')
                {
                    $pocDesignation2 = $organizationData->poc_designation2;

                    $check = Designation::where('name', 'LIKE', $organizationData->poc_designation2)->first();
                    // dd($check);
                    if($check)
                    {
                        $pocDesignationId2 = $check->id;                        
                    }
                    else
                    {
                        
                        $data = array(
                            'name' => $pocDesignation2,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );
                        $storeDesignation = $designationRepository->store($data);
                        $pocDesignationId2 = $storeDesignation->id;
                    }
                }

                if($organizationData->poc_designation3 !='')
                {
                    $pocDesignation3 = $organizationData->poc_designation3;

                    $check = Designation::where('name', 'LIKE', $organizationData->poc_designation3)->first();

                    if($check)
                    {
                        
                        $pocDesignationId3 = $check->id;
                        
                    }
                    else
                    {
                        
                        $data = array(
                            'name' => $pocDesignation3,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );
                        $storeDesignation = $designationRepository->store($data);
                        $pocDesignationId3 = $storeDesignation->id;

                    }
                }

                if($organizationData->website_url){
                    $url = preg_replace("(^https?://)", "", $organizationData->website_url);
                    $webUrl = explode("/", $url);

                    $websiteUrl = $webUrl[0];
                    
                }

                //FETCH DATA FROM TABLE
                $model = $organizationRepository->fetch($id);
               
                $model->name = $organizationData->organization_name; 
                $model->address = $organizationData->organization_address; 
                $model->pincode = $organizationData->pincode;  
                $model->post_office = $organizationData->post_office;  
                $model->country = $organizationData->country;   
                $model->state = $organizationData->state;   
                $model->district = $organizationData->district;   
                $model->taluk = $organizationData->taluk;   
                $model->city = $organizationData->city;  
                $model->office_email = $organizationData->office_email_id;   
                $model->mobile_number = $organizationData->office_mobile_number;   
                $model->landline_number = $landlineNumber;  
                $model->poc_name1 = $organizationData->poc_name1;  
                $model->poc_designation1 = $pocDesignationId1;    
                $model->poc_contact_number1 = $organizationData->poc_phoneNumber1;  
                $model->poc_email1 = $organizationData->poc_email_Id1;  
                $model->poc_name2 = $organizationData->poc_name2;  
                $model->poc_designation2 = $pocDesignationId2;    
                $model->poc_contact_number2 = $organizationData->poc_phoneNumber2;  
                $model->poc_email2 = $organizationData->poc_email_Id2;  
                $model->poc_name3 = $organizationData->poc_name3;  
                $model->poc_designation3 = $pocDesignationId3;    
                $model->poc_contact_number3 = $organizationData->poc_phoneNumber3;  
                $model->poc_email3 = $organizationData->poc_email_Id3; 
                $model->website_url = $websiteUrl;  
                $model->gst_number = strtoupper($organizationData->gst_number); 
                $model->gst_attachment = $gstAttachment; 
                $model->pan_number = strtoupper($organizationData->pan_number);  
                $model->pan_attachment = $panAttachment; 
                $model->registration_certificate = $registrationAttachment;  
                $model->logo = $organizationLogo;   
                $model->po_signed_date = $poSignedDate;  
                $model->po_effective_date = $poEffectiveDate;   
                $model->po_attachment = $poAttachment; 
                $model->contract_period = $organizationData->contract_period; 
                $model->po_expiry_date = $expiryPoDate;  
                $model->yearly_renewal_period = $renewalPeriod; 
                $model->modified_by = Session::get('userId'); 
                $model->updated_at = Carbon::now(); 
                
                $response = $organizationRepository->update($model);

                if($response){

                    $managementResponse = $organizationManagementService->updateOrganizationManagement($organizationData, $id);
                    
                    $signal = 'success';
                    $msg = 'Data updated successfully!';
                 
                }else{

                    $signal = 'failure';
                    $msg = 'Error updating data!';

                } 

            }else{

                $signal = 'exist';
                $msg = 'This data already exists!';
                
            } 
            
            $output = array(
                'signal'=> $signal,
                'message'=> $msg
            );

            return $output;
        }

        public function delete($id){

            $organizationRepository = new OrganizationRepository();
            $institutionRepository = new InstitutionRepository;
            $getInstitutions = $institutionRepository->fetchInstitution($id);

            if(count($getInstitutions) > 0){
                $signal = 'success';
                $msg = 'Data can\'t be deleted since it is already mapped!';
            }else{
                $organization = $organizationRepository->delete($id);
                if($organization){
                    $signal = 'success';
                    $msg = 'Data deleted successfully!';
                }else {
                    $signal = 'failure';
                    $msg = 'Error in deleting!';
                }
            }
           
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function fetchDetails($id){

            $organizationRepository = new OrganizationRepository();
            $organization = $organizationRepository->fetch($id);

            $organizationDetails = array(
                'address'=>$organization->address,
                'pincode'=>$organization->pincode,
                'city'=>$organization->city,
                'state'=>$organization->state,
                'district'=>$organization->district,
                'taluk'=>$organization->taluk,
                'country'=>$organization->country,
                'post_office'=>$organization->post_office
            );
            return $organizationDetails;
        }

        public function getDeletedRecords(){
            $organizationRepository = new OrganizationRepository();
            $allDeletedOrganizations = $organizationRepository->allDeleted();
            return $allDeletedOrganizations;
        }

        
        public function restore($id){
            $organizationRepository = new OrganizationRepository();
            $organization = $organizationRepository->restore($id);

            if($organization){
                $signal = 'success';
                $msg = 'Data restored successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function restoreAll(){
            $organizationRepository = new OrganizationRepository();
            $organization = $organizationRepository->restoreAll();

            if($organization){
                $signal = 'success';
                $msg = 'Data restored successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function fetchTableColumns(){

            // $columnArray = ['gender', 'blood_group', 'designation', 'department', 'role', 'staff_category', 'staff_subcategory', 'nationality', 'religion', 'caste_category'];
            $allColumns = DB::getSchemaBuilder()->getColumnListing('tbl_organization');

            $unNeededColumns = ['id', 'type', 'poc_name1', 'poc_designation1', 'poc_contact_number1', 'poc_email1', 'poc_name2', 'poc_designation2', 'poc_contact_number2', 'poc_email2', 'poc_name3', 'poc_designation3', 'poc_contact_number3', 'poc_email3', 'website_url', 'gst_number', 'gst_attachment', 'pan_number', 'pan_attachment', 'registration_certificate', 'po_signed_date', 'po_effective_date', 'po_attachment', 'contract_period', 'po_expiry_date', 'yearly_renewal_period', 'created_by', 'modified_by', 'deleted_at', 'created_at', 'updated_at'];
            $neededColumns = array_diff($allColumns, $unNeededColumns);
            // array_push($neededColumns, ...$columnArray);
            return $neededColumns;

        }

        public function findTokenData($idOrganization){

            $organizationRepository = new OrganizationRepository();
            $organization = $organizationRepository->fetch($idOrganization);

            return $organization;
        }
    }
?>