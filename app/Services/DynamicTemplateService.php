<?php
    namespace App\Services;
    use App\Models\DynamicTemplate;
    use App\Services\DynamicTemplateService;
    use App\Services\StudentService;
    use App\Repositories\DynamicTemplateRepository;
    use Carbon\Carbon;
    use Session;
    use Storage;

    class DynamicTemplateService
    {
        // Get All DynamicTemplate
        public function getAll(){
            $dynamicTemplateRepository = new DynamicTemplateRepository();
            $templates = $dynamicTemplateRepository->all();
            return $templates;
        }

        public function getAllCertificates($type){
            $dynamicTemplateRepository = new DynamicTemplateRepository();
            $templates = $dynamicTemplateRepository->allCertificate($type);
            return $templates;
        }

        //FETCH TEMPLATE DATA
        public function find($id){
            $dynamicTemplateRepository = new DynamicTemplateRepository();
            $templates = $dynamicTemplateRepository->fetch($id);
            return $templates;
        }

        //STORE DYNAMIC TEMPLATE
        public function add($request){
            // dd($request);
            $dynamicTemplateRepository = new DynamicTemplateRepository();
            
            $check = DynamicTemplate::where('template_category', $request->template_category)
                    ->where('template_name', $request->template_name)
                    ->first();
            
            if(!$check){
                
                $data = array(
                    'template_category' => $request->template_category, 
                    'template_name' => $request->template_name, 
                    'template_content' => $request->template_description, 
                    'created_by' => Session::get('userId'),
                );
                // dd($data);
                $storeData = $dynamicTemplateRepository->store($data); 
                
                if($storeData) {

                    $signal = 'success';
                    $msg = 'Data inserted successfully!';

                }else{

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

        //UPDATE DYNAMIC TEMPLATE
        public function update($request, $id){
            
            $dynamicTemplateRepository = new DynamicTemplateRepository();
            
            $check = $dynamicTemplateRepository->fetch($id);
                
            
            $check->template_category = $request->template_category;
            $check->template_name = $request->template_name;
            $check->template_content = $request->template_description; 
            $check->modified_by = Session::get('userId');
           
            // dd($data);
            $storeData = $dynamicTemplateRepository->update($check); 
            
            if($storeData) {

                $signal = 'success';
                $msg = 'Data updated successfully!';

            }else{

                $signal = 'failure';
                $msg = 'Error inserting data!';

            } 
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function getTokens(){

            $staffService = new StaffService();
            $studentService = new StudentService();
            $instituteService = new InstituteService();
            $organizationService = new OrganizationService();
            $resultService = new ResultService();

            $entityArray = ["organization", "institution", "student", "staff", "result"];
            $serviceArray = [$organizationService, $instituteService, $studentService, $staffService, $resultService];

            $columnArray = array();

            foreach($entityArray as $index => $entity){
                $column[$index]['entity'] = $entity;
                $column[$index]['columns'] = $serviceArray[$index]->fetchTableColumns();
            }

            return $column;
        }

        public function getDynamicTemplateData($request, $manualTokens){
            
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $organizationId = $allSessions['organizationId'];
            $academicYear = $allSessions['academicYear'];

            $staffService = new StaffService();
            $studentService = new StudentService();
            $instituteService = new InstituteService();
            $organizationService = new OrganizationService();
            $resultService = new ResultService();
            
            $templateData = $this->find($request->templateId);
            $customTemplateContent = $templateData->template_content;
            // dd($customTemplateContent);
            // $allTokens = $this->getTokens();
            $studentTokens = $studentService->fetchTableColumns();
            $entityArray = ["organization", "institution", "student"];
            $tokenArray = array(); 
            $serviceArray = [$organizationService, $instituteService, $studentService];
            
            foreach($entityArray as $index => $entity){

                if($entity === "organization"){
                    $id = $organizationId;
                }else if($entity === "institution"){
                    $id = $institutionId;
                }else{
                    $id = $request->studentId;
                }
                
                $allTokens = $serviceArray[$index]->fetchTableColumns();
                $studentData = $serviceArray[$index]->findTokenData($id);

                foreach($allTokens as $key => $token){
                    $tokenArray["".$entity.".".$token.""] = ucwords($studentData->$token);
                    if($entity.".".$token == $entity.'.logo'){
                        $tokenArray["".$entity.".".$token.""] = '<img src="data:image/png;base64,'.base64_encode(file_get_contents($studentData->$token)).'" alt="logo">';
                    }
                }

                foreach($manualTokens as $token){
                    $tokenArray["".$token.""] = $request->$token;
                }
            }
            
			$pattern = '[#%s#]';
            $customPattern = '$%s';
			
			foreach($tokenArray as $key => $val){
				$varMap[sprintf($pattern, $key)] = $val;
			}

            foreach($tokenArray as $key => $val){
				$varMap[sprintf($customPattern, $key)] = $val;
			}

			$templateContent = strtr($customTemplateContent, $varMap);	
            
            return $templateContent;
        }

    }
?>