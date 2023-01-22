<?php 
    namespace App\Services;
    use App\Models\ExamMaster;
    use App\Services\SubjectService;
    use App\Repositories\ExamMasterRepository;
    use App\Services\InstitutionStandardService;
    use Session;
    use Carbon\Carbon;

    class ExamMasterService 
    {
<<<<<<< HEAD
        public function all()
        {
            $institutionStandardService = new InstitutionStandardService();
            $examMasterRepository = new ExamMasterRepository();
            $allExamMasters = $examMasterRepository->all();
=======
        public function all($allSessions)
        {
            $institutionStandardService = new InstitutionStandardService();
            $examMasterRepository = new ExamMasterRepository();
            $allExamMasters = $examMasterRepository->all($allSessions);
>>>>>>> main
            $examMasterDetails = array();
            
            foreach($allExamMasters as $index => $examDetails)
            {
                $className = array();
                $standardIds = explode(',', $examDetails->id_standard);
                foreach($standardIds as $idStandard)
                {
                    $className[$index][] = $institutionStandardService->fetchStandardByUsingId($idStandard);
                }   
                $class = implode(',', $className[$index]);
               

                $fromDate = Carbon::createFromFormat('Y-m-d', $examDetails->from_date)->format('d/m/Y');
                $toDate = Carbon::createFromFormat('Y-m-d', $examDetails->to_date)->format('d/m/Y');

                $examMasterDetails[$index] = array(
                        'id'=>$examDetails->id,
                        'class_name'=>$class,
                        'exam_name'=>$examDetails->name,
                        'from_date'=>$fromDate,
                        'to_date'=>$toDate
                    );
            } 
            return $examMasterDetails;        
        }

        public function find($id)
        {
            $institutionStandardService = new InstitutionStandardService();
            $examMasterRepository = new ExamMasterRepository();
            $examDetails = $examMasterRepository->fetch($id);
            $standardDetails = array();
            $standardIds = explode(',', $examDetails->id_standard);
            foreach($standardIds as $key => $standard)
            {
                $className = $institutionStandardService->fetchStandardByUsingId($standard);
                $standardDetails[$key]['id'] = $standard;
                $standardDetails[$key]['label'] = $className;
            }
            $fromDate = Carbon::createFromFormat('Y-m-d', $examDetails->from_date)->format('d/m/Y');
            $toDate = Carbon::createFromFormat('Y-m-d', $examDetails->to_date)->format('d/m/Y');
            
            $examMasterDetails = array(
                    'id'=>$examDetails->id,
                    'class_name'=>$standardIds,
                    'standard_details'=>$standardDetails,
                    'exam_name'=>$examDetails->name,
                    'from_date'=>$fromDate,
                    'to_date'=>$toDate
                );
            return $examMasterDetails;
        }   
    
        public function add($examMasterData)
        {
            $examMasterRepository = new ExamMasterRepository();
<<<<<<< HEAD
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
=======
            
            $institutionId = $examMasterData->id_institute;
            $academicYear = $examMasterData->id_academic;
>>>>>>> main

            $count = 0;
            $existCount = 0;

            foreach($examMasterData->exam_name as $key => $examName) 
            {
                $allStandard = implode(',', $examMasterData->standard[$key+1]);

                $fromDate = Carbon::createFromFormat('d/m/Y', $examMasterData->from_date[$key])->format('Y-m-d');
                $toDate = Carbon::createFromFormat('d/m/Y', $examMasterData->to_date[$key])->format('Y-m-d');

                $check = ExamMaster::where('id_academic_year', $academicYear)
                        ->where('id_institute', $institutionId)
                        ->where('name', $examName)
                        ->where('id_standard', $allStandard)
                        // ->where(function($q) use ($fromDate, $toDate){
                        //     $q->where('from_date', $fromDate)
                        //     ->orWhere('to_date', $toDate);
                        // })
                        ->first();
                if(!$check){

                    $data = array( 
                        'id_academic_year' => $academicYear,
                        'id_institute' => $institutionId,
                        'id_standard' => $allStandard,
                        'name' => $examName,
                        'from_date' => $fromDate,
                        'to_date' => $toDate,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                    );
                    $storeSubject = $examMasterRepository->store($data);

                    if($storeSubject){
                        $count++;
                    }
                }else{
                    $existCount++;
                }
            }

            if($count > 0){

                $signal = 'success';
                $msg = 'Data inserted successfully!';

            }else if($existCount > 0){

                $signal = 'exist';
                $msg = 'Data already exists!';
                
            }else{
                $signal = 'failure';
                $msg = 'Error in saving data';
            }
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;
        }

         public function update($examMasterData, $id){
           
            $examMasterRepository = new ExamMasterRepository();
<<<<<<< HEAD
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
=======
            
            $institutionId = $examMasterData->id_institute;
            $academicYear = $examMasterData->id_academic;
>>>>>>> main

            $fromDate = Carbon::createFromFormat('d/m/Y', $examMasterData->from_date)->format('Y-m-d');
            $toDate = Carbon::createFromFormat('d/m/Y', $examMasterData->to_date)->format('Y-m-d');
            $allStandard = implode(',', $examMasterData->standard);

            $check = ExamMaster::where('id_academic_year', $academicYear)
                                ->where('id_institute', $institutionId)
                                ->where('name', $examMasterData->exam_name)
                                // ->where(function($q) use ($fromDate, $toDate){
                                //     $q->where('from_date', $fromDate)
                                //     ->orWhere('to_date', $toDate);
                                // })
                                ->where('id', '!=', $id)
                                ->first();
            if(!$check){

                $examDetails = $examMasterRepository->fetch($id);
                
                $examDetails->id_standard = $allStandard;
                $examDetails->name = $examMasterData->exam_name;
                $examDetails->from_date = $fromDate;
                $examDetails->to_date = $toDate;
                $examDetails->modified_by = Session::get('userId');
                $examDetails->updated_at = Carbon::now();

                $updateData = $examMasterRepository->update($examDetails); 
              
                if($updateData) {

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
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

<<<<<<< HEAD
        public function findExamsForStandard($institutionStandardId)
        {     
            $examMasterRepository = new ExamMasterRepository();
            $examDetails = $examMasterRepository->fetchExamMaster($institutionStandardId);
=======
        public function findExamsForStandard($institutionStandardId, $allSessions)
        {     
            $examMasterRepository = new ExamMasterRepository();
            $examDetails = $examMasterRepository->fetchExamMaster($institutionStandardId, $allSessions);
>>>>>>> main
            return $examDetails;
        }
     
    }
?>