<?php 
    namespace App\Services;
    use App\Models\InstitutionSubject;
    use App\Services\SubjectService;
    use App\Repositories\InstitutionSubjectRepository;
    use App\Repositories\SubjectTypeRepository;
    use App\Repositories\SubjectRepository;
    use App\Repositories\StandardSubjectRepository;
    use Session;
    use Carbon\Carbon;

    class InstitutionSubjectService 
    {
        public function getSubjectWithType()
        { 
            $subjectTypeRepository = new SubjectTypeRepository();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $arraySubjectType = array();

            $subjectTypes = $subjectTypeRepository->all();
            foreach($subjectTypes as $type)
            {
                $subjectDetails = array();
                $allSubjectDetails =  $institutionSubjectRepository->fetch($type->id);
                foreach($allSubjectDetails as $key => $details)
                {
                    $subjectDetails[$key] = $details;
                    $subjectCount =  $institutionSubjectRepository->findCount($details->id_subject);
                    if(sizeof($subjectCount) == 2)
                    {
                        $subjectDetails[$key]['label_with_type'] = $details['display_name'].'-'.$details['subject_type'];
                    }
                    else
                    {
                        $subjectDetails[$key]['label_with_type'] = $details['display_name'];
                    }
                }
                $arraySubjectType[$type->label] = $subjectDetails;
            }
           
            return $arraySubjectType;

        }

        public function getAll()
        { 
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $subjectService = new SubjectService();
            $subjectTypeRepository = new SubjectTypeRepository();
            $subjectRepository = new SubjectRepository();

            $subjectDetails = array();

            $allSubject = $institutionSubjectRepository->all();
            foreach($allSubject as $subject)
            {
                $subjectData = $subjectService->find($subject->id_subject);
                $type = $subjectTypeRepository->fetch($subjectData->id_type);

                $subjectNameCount = $subjectRepository->fetchSubjectNameCount($subjectData->name);
                if(count($subjectNameCount) > 1){
                    $subjectName = $subjectData->name.' ( '.$type->display_name.' )';
                }else{
                    $subjectName = $subjectData->name;
                }
                
                $subjectCount =  $institutionSubjectRepository->findCount($subject->id_subject);
                if(sizeof($subjectCount) > 1){
                    $display_name = $subject['display_name'].'-'.$subject['subject_type'];
                }else{
                    $display_name = $subject['display_name'];
                }

                $subjectDetails[$subject->id] = array(
                    'id' => $subject->id,
                    'id_subject' => $subject->id_subject,
                    'subject_name' => $subjectName,
                    'display_name' => $display_name,
                    'subject_type' => $subject->subject_type
                );
            }
         
            return $subjectDetails;
        }

        public function getSubjectName($idSubject)
        { 
            $institutionSubjectRepository = new InstitutionSubjectRepository();

            $insttutionSubjectData = $institutionSubjectRepository->find($idSubject);
            
            $displayName = '';
            
            if($insttutionSubjectData){
            
                $subjectCount =  $institutionSubjectRepository->findCount($insttutionSubjectData->id_subject);
                
                if(sizeof($subjectCount) == 2)
                {
                    $displayName = $insttutionSubjectData['display_name'].'-'.$insttutionSubjectData['subject_type'];
                }
                else
                {
                    $displayName = $insttutionSubjectData['display_name'];
                }
            }
            
            return $displayName;
        }

        public function add($institutionSubjectData)
        {
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $count = $existCount = 0;

            foreach($institutionSubjectData->subject as $key => $subject){
                
                $displayName = $institutionSubjectData->display_name[$key];
                $subjectType = $institutionSubjectData->subject_type[$key+1];
                
                foreach($subjectType as $type){
                    
                    $check = InstitutionSubject::where('id_institute', $institutionId)
                        // ->where('id_academic_year', $academicYear)
                        ->where('id_subject', $subject)
                        ->where('subject_type', $type)
                        ->first();
                    if(!$check){
                 
                        $data = array( 
                            'id_academic_year' => $academicYear,
                            'id_institute' => $institutionId,
                            'id_subject' => $subject,
                            'display_name' => $displayName,
                            'subject_type' => $type,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );
                        $storeSubject = $institutionSubjectRepository->store($data);

                        if($storeSubject){
                            $count++;
                        }
                    }else{
                        $existCount++;
                    }
                }
            }
            if($count > 0){
                $signal = 'success';
                $msg = 'Data inserted successfully!';
            }else if($existCount > 0){
                $signal = 'exist';
                $msg = 'Data already exist!';
            }else{
                $signal = 'failure';
                $msg = 'Error saving data';
            }            
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;
        }

        public function getPeriodWiseSubjectData($attendanceType){

            $subjectTypeRepository = new SubjectTypeRepository();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $subjectService = new SubjectService();
            $subjectRepository = new SubjectRepository();
            $attendanceSubjects = array();

            $attendanceSubjects = $institutionSubjectRepository->fetchInstitutionAttendanceSubject($attendanceType);
            // dd($attendanceSubjects);
            foreach($attendanceSubjects as $key => $subjectData){
                $attendanceSubjects[$key] = $subjectData;

                $subjectDetail = $subjectService->find($subjectData['id_subject']);
                // dd($subjectDetail->name);
                $type = $subjectTypeRepository->fetch($subjectDetail->id_type);

                $subjectNameCount = $subjectRepository->fetchSubjectNameCount($subjectDetail->name);
                if(count($subjectNameCount) > 1){
                    $subjectType = ' ( '.$type->display_name.' )';
                }else{
                    $subjectType = '';
                }

                $attendanceSubjects[$key]['display_name'] = $subjectData['display_name'].$subjectType;
            }
            return $attendanceSubjects;
        }

        public function getSubjectLabel($institutionSubjectId)
        { 
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $subjectService = new SubjectService();
            $institutionSubjectData = $institutionSubjectRepository->find($institutionSubjectId);
            return $subjectService->fetchSubjectTypeDetails($institutionSubjectData->id_subject);
        }

        public function delete($id){
            
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $standardSubjectRepository = new StandardSubjectRepository();

            $checkExistence = $standardSubjectRepository->fetchExamSubjectStandards($id);
            if(count($checkExistence) > 0){

                $signal = 'success';
                $msg = 'Data can\'t be deleted since it is already mapped!';

            }else{
                $result = $institutionSubjectRepository->delete($id);

                if($result){
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

        public function getData($id){
            $institutionSubjectRepository = new InstitutionSubjectRepository();

            $subjectData = $institutionSubjectRepository->find($id);
            return $subjectData;
        }

        public function update($request, $id){
            $institutionSubjectRepository = new InstitutionSubjectRepository();

            $subjectData = $institutionSubjectRepository->find($id);

            $subjectData->display_name = $request->display_name;
            $subjectData->modified_by = Session::get('userId');

            $storeData = $institutionSubjectRepository->update($subjectData);

            if($storeData){
                $signal = 'success';
                $msg = 'Data updates successfully!';
            }else{
                $signal = 'failure';
                $msg = 'Error saving data';
            }            
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;

        }

        public function getInstitutionSubjectWithType(){
            $subjectService = new SubjectService();
            $allSubjects = $subjectService->getSubjects();
            $institutionSubjects = $this->getAll();

            $commonSubjects   =  array();
            $electiveSubjects =  array();
            $languageSubjects =  array();
            $institutionSubjectsDetails = array();
            $institutionSubjectsId = array();

            foreach($institutionSubjects as $subjects) {
                $institutionSubjectsId[] = $subjects['id_subject'];
            }          

            foreach($allSubjects['common'] as $commonKey => $common){

                if(in_array($common->id, $institutionSubjectsId)){
                    $commonSubjects[$commonKey]['subject_master_id'] = $common->id;
                    $commonSubjects[$commonKey]['subject_name'] = $common->name;
                }
            }

            foreach($allSubjects['elective'] as $electiveKey => $elective){

                if(in_array($elective->id, $institutionSubjectsId)){
                    $electiveSubjects[$electiveKey]['subject_master_id'] = $elective->id;
                    $electiveSubjects[$electiveKey]['subject_name'] = $elective->name;
                }
            }

            foreach($allSubjects['language'] as  $languageKey =>  $language){

                if(in_array($language->id, $institutionSubjectsId)){
                    $languageSubjects[$languageKey]['subject_master_id'] = $language->id;
                    $languageSubjects[$languageKey]['subject_name'] = $language->name;
                }
            }

            $institutionSubjectsDetails = array(
                'language_subjects'=>$languageSubjects,
                'elective_subjects'=>$electiveSubjects,
                'common_subjects'=>$commonSubjects
            );

            return $institutionSubjectsDetails;
        }
    }
?>