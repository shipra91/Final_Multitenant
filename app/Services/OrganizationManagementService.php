<?php 
    namespace App\Services;
    use App\Repositories\OrganizationManagementRepository;
    use App\Models\OrganizationManagement;
    use App\Repositories\DesignationRepository;
    use App\Models\Designation;
    use Carbon\Carbon;
    use Session;
    use DB;

    class OrganizationManagementService {

        public function all()
        {
            $organizationManagementRepository = new OrganizationManagementRepository();
            $OrganizationManagement = $organizationManagementRepository->all();
            return $OrganizationManagement;        
        }
        
        public function getOrganizationManagements($idOrganization)
        {
            $designationRepository = new DesignationRepository();
            $organizationManagementRepository = new OrganizationManagementRepository();
            $OrganizationManagement = $organizationManagementRepository->fetchOrganizationManagement($idOrganization);
            $data= array();
            foreach($OrganizationManagement as $index=>$org)
            {   
                $data[$index] = $org;
                $data[$index]['designation_name'] = '';

                $designationDetails = $designationRepository->fetch($org['designation']);
                if($designationDetails){
                    $data[$index]['designation_name'] = $designationDetails->name;
                } 
            }
            return $data;
        }
    
        public function add($OrganizationManagementData, $lastInsertedId)
        {   
            $designationRepository = new DesignationRepository();
            $organizationManagementRepository = new OrganizationManagementRepository();
  
            if($OrganizationManagementData->management_name[0] !='')
            {
                foreach($OrganizationManagementData->management_name as $key => $managementName) 
                {
                    if($OrganizationManagementData->management_designation[$key] !='')
                    {
                        $phoneNumber = $OrganizationManagementData->management_phoneNumber[$key];
                        $email = $OrganizationManagementData->management_email_id[$key];
                        $designation = $OrganizationManagementData->management_designation[$key];
                  
                        $check = Designation::where('name', 'LIKE', $designation)->first();

                        if(!$check)
                        {
                            $data = array(
                                'name' => $designation,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );
                            $storeDesignation = $designationRepository->store($data);
                            $designationId = $storeDesignation->id;
                        }
                        else
                        {
                            $designationId = $check->id;
                        }

                        $data = array(
                           'id_organization' => $lastInsertedId,
                           'name' => $managementName,
                           'designation' => $designationId,
                           'email' => $email,
                           'mobile_number' => $phoneNumber,
                           'created_by' => Session::get('userId'),
                           'created_at' => Carbon::now()
                       );
                        $storeManagement = $organizationManagementRepository->store($data);
                    }
               }
            }
            $signal = 'success';
            $msg = 'Data inserted successfully!';
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;
        }

        public function updateOrganizationManagement($organizationManagementData, $organizationId)
        {
            $designationRepository = new DesignationRepository();
            $organizationManagementRepository = new OrganizationManagementRepository();
            DB::enableQueryLog();
            if($organizationManagementData->management_name[0] !='')
            {
                foreach($organizationManagementData->management_name as $key => $managementName) 
                {
                    if($organizationManagementData->management_designation[$key] !='')
                    {                
                            
                        $designation = $organizationManagementData->management_designation[$key];
                        $phoneNumber = $organizationManagementData->management_phoneNumber[$key];
                        $email = $organizationManagementData->management_email_id[$key];
                        $id = $organizationManagementData->management_id[$key];
                        
                        $check = Designation::where('name', 'LIKE', $designation)->first();
                        // dd(DB::getQueryLog());
                        if(!$check){
                            $data = array(
                                'name' => $designation,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );
                            $storeDesignation = $designationRepository->store($data);
                            $designationId = $storeDesignation->id;
                        }else{
                            $designationId = $check->id;
                        }

                        if($id!=''){

                            $model = $organizationManagementRepository->fetch($id);

                            $model->name = $managementName;
                            $model->designation = $designationId;
                            $model->email = $email;
                            $model->mobile_number = $phoneNumber;
                            $model->modified_by = Session::get('userId');
                            $model->updated_at = Carbon::now();
                                
                            $response = $organizationManagementRepository->updateOrganizationManagement($model);
                        }else{

                            $data = array(
                                'id_organization' => $organizationId,
                                'name' => $managementName,
                                'designation' => $designationId,
                                'email' => $email,
                                'mobile_number' => $phoneNumber,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );
                            $response = $organizationManagementRepository->store($data);
                        }                       
                    }
                }
            }
        }

        public function delete($id)
        {
            
            $organizationManagementRepository = new OrganizationManagementRepository();
            $organization = $organizationManagementRepository->delete($id);

            if($organization){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>