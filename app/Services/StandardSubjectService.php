<?php
    namespace App\Services;
    use App\Models\StandardSubject;
    use App\Services\SubjectService;
    use App\Repositories\StandardSubjectRepository;
    use App\Repositories\InstitutionSubjectRepository;
    use App\Services\InstitutionStandardService;
    use App\Services\StandardSubjectStaffMappingService;
    use App\Repositories\SubjectRepository;
    use App\Repositories\InstitutionStandardRepository;
    use App\Repositories\ExamSubjectConfigurationRepository;
    use App\Repositories\SubjectPartRepository;
    use App\Repositories\SubjectTypeRepository;
    use Session;
    use Carbon\Carbon;

    class StandardSubjectService {

        public function all($allSessions){

            $institutionStandardService = new InstitutionStandardService();
            $subjectService = new SubjectService();
            $studentService = new StudentService();
            $standardSubjectStaffMappingService = new StandardSubjectStaffMappingService();
            $standardSubjectRepository = new StandardSubjectRepository();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $standardSubjectIds =  array();
            $standardSubjectsDetails = array();

            $allStandardSubjects = $standardSubjectRepository->all($allSessions);
            // dd($allStandardSubjects);

            foreach($allStandardSubjects as $key => $subject){
                $subjectDetails = $institutionSubjectRepository->find($subject->id_institution_subject);
                $standardSubjectIds[$subject->id_standard][$key] = $subjectDetails->id_subject;
            }

            $allSubjects = $subjectService->getSubjects();

            foreach($standardSubjectIds as $index => $subjectIds){

                $commonSubjects =  array();
                $electiveSubjects =  array();
                $languageSubjects =  array();

                foreach($allSubjects['common'] as $key => $common){

                    if(in_array($common->id, $subjectIds)){
                        $commonSubjects[$common->id] = $common->name;
                    }
                }

                foreach($allSubjects['elective'] as $key => $elective){

                    if(in_array($elective->id, $subjectIds)){
                        $electiveSubjects[$elective->id] = $elective->name;
                    }
                }

                foreach($allSubjects['language'] as  $key =>  $language){

                    if(in_array($language->id, $subjectIds)){
                        $languageSubjects[$language->id] = $language->name;
                    }
                }

                $className = $institutionStandardService->fetchStandardByUsingId($index);

                // Get student
                $studentData = $studentService->fetchStandardStudents($index, $allSessions);
                $mappedData = $standardSubjectStaffMappingService->fetchIfSubjectIsMapped($index, $allSessions);

                // dd($mappedData);
                if(count($studentData) > 0 || count($mappedData) > 0){
                    $action = "";
                }else{
                    $action = "action";
                }

                $standardSubjectsDetails[$index] = array(
                        'id'=>$index,
                        'class_name'=>$className,
                        'action' => $action,
                        'language_subjects'=>implode(',' , $languageSubjects),
                        'elective_subjects'=>implode(',' , $electiveSubjects),
                        'common_subjects'=>implode(',' , $commonSubjects)
                    );
            }

            return $standardSubjectsDetails;
        }

        public function add($standardSubjectData){

            $standardSubjectRepository = new StandardSubjectRepository();

            $institutionId = $standardSubjectData->id_institute;
            $academicYear = $standardSubjectData->id_academic;

            if($standardSubjectData->common_subject[0] !=''){

                foreach($standardSubjectData->common_subject as $key => $commonSubject){

                    $check = StandardSubject::where('id_academic_year', $academicYear)
                                            ->where('id_institute', $institutionId)
                                            ->where('id_institution_subject', $commonSubject)
                                            ->where('id_standard', $standardSubjectData->standard)
                                            ->first();

                    if(!$check){

                        $displayName = '';
                        $data = array(
                        'id_academic_year' => $academicYear,
                        'id_institute' => $institutionId,
                        'id_standard' => $standardSubjectData->standard,
                        'id_institution_subject' => $commonSubject,
                        'display_name' => $displayName,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                        );

                        $storeSubject = $standardSubjectRepository->store($data);
                    }
                }
            }

            if($standardSubjectData->elective_subject[0] !=''){

                foreach($standardSubjectData->elective_subject as $key => $electiveSubject){

                    $check = StandardSubject::where('id_academic_year', $academicYear)
                                            ->where('id_institute', $institutionId)
                                            ->where('id_institution_subject', $electiveSubject)
                                            ->where('id_standard', $standardSubjectData->standard)
                                            ->first();

                    if(!$check){

                        $displayName = '';
                        $data = array(
                        'id_academic_year' => $academicYear,
                        'id_institute' => $institutionId,
                        'id_standard' => $standardSubjectData->standard,
                        'id_institution_subject' => $electiveSubject,
                        'display_name' => $displayName,
                        'created_by' => Session::get('userId'),
                        'updated_at' => Carbon::now()
                        );

                        $storeSubject = $standardSubjectRepository->store($data);
                    }
                }
            }

            if($standardSubjectData->language_subject[0] !=''){

                foreach($standardSubjectData->language_subject as $key => $languageSubject){

                    $check = StandardSubject::where('id_academic_year', $academicYear)
                                            ->where('id_institute', $institutionId)
                                            ->where('id_institution_subject', $languageSubject)
                                            ->where('id_standard', $standardSubjectData->standard)
                                            ->first();

                    if(!$check){

                        $displayName = '';
                        $data = array(
                        'id_academic_year' => $academicYear,
                        'id_institute' => $institutionId,
                        'id_standard' => $standardSubjectData->standard,
                        'id_institution_subject' => $languageSubject,
                        'display_name' => $displayName,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                        );

                        $storeSubject = $standardSubjectRepository->store($data);
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

        public function fetchSubject($id, $allSessions){

            $standardSubjectRepository = new StandardSubjectRepository();
            $standardSubjectService = new StandardSubjectService();
            $subjectService = new SubjectService();

            $electiveSubjectsDetails = '';
            $languageSubjectsDetails = '';
            $commonSubjectsDetails = '';
            $allSubjectDetails = array();
            $standardSubjectIds = array();
            $allElectiveSubjets = array();
            $allLanguageSubjets = array();
            $allSubjects = $subjectService->getSubjects();

            $institutionStandardSubject =  $standardSubjectRepository->fetchStandardSubjects($id, $allSessions);

            foreach($institutionStandardSubject as $index => $subject){
                $standardSubjectIds[$index] = $subject->id_subject;
            }

            $count = 0;

            foreach($allSubjects['language'] as $index => $data){

                if(in_array($data->id, $standardSubjectIds)){

                    $standardSubjectData = $standardSubjectRepository->getStandardsSubjectDetails($id, $data->id, $allSessions);
                    $allLanguageSubjets[$count]['id'] = $standardSubjectData->id_institution_subject;
                    $allLanguageSubjets[$count]['name'] = $standardSubjectData->display_name;
                    // $languageSubjectsDetails.='<option value="'.$data->id.'" >'.$data->name.'</option>';
                    $allSubjectDetails[$data->id]['id'] = $standardSubjectData->id_institution_subject;
                    $allSubjectDetails[$data->id]['name'] = $standardSubjectData->display_name;

                    $count++;
                }
            }

            $k = 0;

            foreach($allSubjects['common'] as $index => $data){

                if(in_array($data->id, $standardSubjectIds)){

                    $standardSubjectData = $standardSubjectRepository->getStandardsSubjectDetails($id, $data->id, $allSessions);
                    $allCommonSubjets[$k]['id'] = $standardSubjectData->id_institution_subject;
                    $allCommonSubjets[$k]['name'] = $standardSubjectData->display_name;
                    // $commonSubjectsDetails.='<option value="'.$data->id.'" >'.$data->name.'</option>';
                    $allSubjectDetails[$data->id]['id'] = $standardSubjectData->id_institution_subject;
                    $allSubjectDetails[$data->id]['name'] = $standardSubjectData->display_name;
                    $k++;
                }
            }

            $key = 0;

            foreach($allSubjects['elective'] as $index => $data){

                if(in_array($data->id, $standardSubjectIds)){

                    $institutionSubjectIdString = '';
                    $standardSubjectData = $standardSubjectRepository->getInstituteSubjectIds($id, $data->id, $allSessions);

                    foreach($standardSubjectData as $institutionSubjectId){
                        $institutionSubjectIdString .= $institutionSubjectId->id.'||';
                    }

                    $institutionSubjectIdString = substr($institutionSubjectIdString, 0,-2);
                    // dd($standardSubjectData);
                    $allElectiveSubjets[$key]['id'] = $institutionSubjectIdString;
                    $allElectiveSubjets[$key]['name'] = $data->name;
                    //$electiveSubjectsDetails.='<option value="'.$data->id.'" >'.$data->name.'</option>';
                    $allSubjectDetails[$data->id]['id'] = $institutionSubjectIdString;
                    $allSubjectDetails[$data->id]['name'] = $data->name;

                    $key++;
                }
            }

            $standardSubjectDetails = array(
                'all_elective_subject'=>$allElectiveSubjets,
                'all_language_subject'=>$allLanguageSubjets,
                'all_subject'=>$allSubjectDetails
            );
            // dd($standardSubjectDetails);
            return $standardSubjectDetails;
        }

        public function fetchStandardSubjects($standardId, $allSessions){

            $institutionStandardService = new InstitutionStandardService();
            $standardSubjectRepository = new StandardSubjectRepository();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $subjectRepository = new SubjectRepository();
            $subjectTypeRepository = new SubjectTypeRepository();
            $allSubjectDetails = array();
            $allStandardDetails = array();
            $allSubjectId = array();

            $standardSubjectDetails =  $standardSubjectRepository->fetchStandardSubjects($standardId);

            foreach($standardSubjectDetails as $key => $subject){

                $subjectData = $institutionSubjectRepository->find($subject->id_institution_subject);
                $subjectCount = $institutionSubjectRepository->findCount($subjectData->id_subject, $allSessions);

                $subjectMasterData = $subjectRepository->fetch($subjectData->id_subject);
                $type = $subjectTypeRepository->fetch($subjectMasterData->id_type);

                $subjectNameCount = $subjectRepository->fetchSubjectNameCount($subjectData->name);
                if(count($subjectNameCount) > 1){
                    $subjectType = ' ( '.$type->display_name.' )';
                }else{
                    $subjectType = '';
                }

                if($subjectData['subject_type'] == "PRACTICAL"){
                    $displayName = $subjectData['display_name'].'-'.$subjectData['subject_type'];
                }else{
                    $displayName= $subjectData['display_name'];
                }

                $className = $institutionStandardService->fetchStandardByUsingId($standardId);
                $allSubjectDetails[$key]['id'] = $subject->id_institution_subject;
                $allSubjectDetails[$key]['name'] = $displayName.$subjectType;
                $allSubjectDetails[$key]['class'] = $className;
            }

            // dd($allSubjectDetails);
            return $allSubjectDetails;
        }

        public function getStandardsSubject($standardIds, $allSessions){

            $standardSubjectRepository = new StandardSubjectRepository();

            $standardSubjectDetails =  $standardSubjectRepository->getStandardsSubject($standardIds, $allSessions);
            $subjectIds = array();
            $allSubjectDetails = array();
            $index = 0;

            foreach ($standardSubjectDetails as $key => $data){

                if($data->subject_type == 'PRACTICAL'){
                    $displayName = $data->display_name.'-'.$data->subject_type;
                }else{
                    $displayName= $data->display_name;
                }

                if (!in_array($data->id, $subjectIds)){
                    $subjectIds[$index] = $data->id;
                    $allSubjectDetails[$index]['id'] = $data->id;
                    $allSubjectDetails[$index]['name'] = $displayName;
                    $index ++;
                }
            }

            return $allSubjectDetails;
        }

        public function fetchSubjectStandards($subjectId){

            $standardSubjectRepository = new StandardSubjectRepository();
            $subjectStandards = $standardSubjectRepository->fetchSubjectStandards($subjectId);

            return $subjectStandards;
        }

        public function getStandardForSubjects($subjectId, $attendanceType, $allSessions){

            $standardSubjectRepository = new StandardSubjectRepository();
            $subjectStandards = $standardSubjectRepository->fetchSubjectStandards($subjectId, $attendanceType, $allSessions);

            return $subjectStandards;
        }

        public function delete($id){

            $standardSubjectRepository = new StandardSubjectRepository();

            $deleteRecord = $standardSubjectRepository->delete($id);

            if($deleteRecord){
                $signal = 'success';
                $msg = 'Mapping deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function checkStandardSubject($request, $idSubject, $allSessions){

            $standardSubjectRepository = new StandardSubjectRepository();

            $nstitutionStandardRepository = new InstitutionStandardRepository();
            $standardDetails = $nstitutionStandardRepository->fetchStandardDetails($request, $allSessions);
            $subjectStandardArray = array();

            foreach($standardDetails as $index => $standard){//1a,1b, hindi

                $result = $standardSubjectRepository->fetchSubjectBelongsToStandard($standard->id, $idSubject, $allSessions);

                if($result){
                    array_push($subjectStandardArray, $standard->id);
                }
            }

            return $subjectStandardArray;
        }

        public function fetchInstitutionStandardSubjects($examId, $standardId, $allSessions){

            $standardSubjectRepository = new StandardSubjectRepository();
            $examSubjectConfigurationRepository = new ExamSubjectConfigurationRepository();
            $subjectPartRepository = new SubjectPartRepository();
            $standardSubjectData = array();
            $gradeTemplate = '';

            $standardSubjectDetails =  $standardSubjectRepository->fetchStandardSubjectsGroupBySubjects($standardId, $allSessions);
            $subjectParts = $subjectPartRepository->all();

            $gradeTemplate = $getStandardSubjectInfo = $examSubjectConfigurationRepository->getExamStandardGrade($examId, $standardId, $allSessions);
            if($gradeTemplateData){
                $gradeTemplate = $gradeTemplateData->id_grade_set;
            }

            if($standardSubjectDetails){
                foreach($standardSubjectDetails as $index => $standardSubject){
                    $standardSubjectData['examConfig'][$index] = $standardSubject;

                    $getStandardSubjectInfo = $examSubjectConfigurationRepository->getExamStandardConfiguration($examId, $standardId, $standardSubject->id_subject, $allSessions);
                    // dd($getStandardSubjectInfo);
                    if($getStandardSubjectInfo){
                        $standardSubjectData['examConfig'][$index]['config_display_name'] = $getStandardSubjectInfo->display_name;
                        $standardSubjectData['examConfig'][$index]['subject_part'] = $getStandardSubjectInfo->subject_part;
                        $standardSubjectData['examConfig'][$index]['priority'] = $getStandardSubjectInfo->priority;
                        $standardSubjectData['examConfig'][$index]['conversion'] = $getStandardSubjectInfo->conversion;
                        $standardSubjectData['examConfig'][$index]['conversion_value'] = $getStandardSubjectInfo->conversion_value;
                        $standardSubjectData['examConfig'][$index]['max_mark'] = $getStandardSubjectInfo->max_mark;
                        $standardSubjectData['examConfig'][$index]['pass_mark'] = $getStandardSubjectInfo->pass_mark;
                    }else{
                        $standardSubjectData['examConfig'][$index]['config_display_name'] = '';
                        $standardSubjectData['examConfig'][$index]['subject_part'] = '';
                        $standardSubjectData['examConfig'][$index]['priority'] = '';
                        $standardSubjectData['examConfig'][$index]['conversion'] = 'NO';
                        $standardSubjectData['examConfig'][$index]['conversion_value'] = '';
                        $standardSubjectData['examConfig'][$index]['max_mark'] = '';
                        $standardSubjectData['examConfig'][$index]['pass_mark'] = '';
                    }
                }
            }

            $standardSubjectData['subjectParts'] = $subjectParts;
            $standardSubjectData['gradeTemplate'] = $gradeTemplate;
            // dd($standardSubjectData);
            return $standardSubjectData;
        }
        
        public function fetchInstitutionStandardExamTimetableSubjects($examId, $standardId, $allSessions){

            $standardSubjectRepository = new StandardSubjectRepository();
            $examSubjectConfigurationRepository = new ExamSubjectConfigurationRepository();
            $subjectPartRepository = new SubjectPartRepository();
            $standardSubjectData = array();
            $gradeTemplate = '';

            $standardSubjectDetails =  $standardSubjectRepository->fetchStandardSubjectsGroupBySubjectsWithExamTimetable($standardId, $allSessions);
            $subjectParts = $subjectPartRepository->all($allSessions);

            $gradeTemplateData = $getStandardSubjectInfo = $examSubjectConfigurationRepository->getExamStandardGrade($examId, $standardId, $allSessions);
            if($gradeTemplateData){
                $gradeTemplate = $gradeTemplateData->id_grade_set;
            }
            if($standardSubjectDetails){
                foreach($standardSubjectDetails as $index => $standardSubject){
                    $standardSubjectData['examConfig'][$index] = $standardSubject;

                    $getStandardSubjectInfo = $examSubjectConfigurationRepository->getExamStandardConfiguration($examId, $standardId, $standardSubject->id_subject, $allSessions);
                    // dd($getStandardSubjectInfo);
                    if($getStandardSubjectInfo){
                        $standardSubjectData['examConfig'][$index]['config_display_name'] = $getStandardSubjectInfo->display_name;
                        $standardSubjectData['examConfig'][$index]['subject_part'] = $getStandardSubjectInfo->subject_part;
                        $standardSubjectData['examConfig'][$index]['priority'] = $getStandardSubjectInfo->priority;
                        $standardSubjectData['examConfig'][$index]['conversion'] = $getStandardSubjectInfo->conversion;
                        $standardSubjectData['examConfig'][$index]['conversion_value'] = $getStandardSubjectInfo->conversion_value;
                        $standardSubjectData['examConfig'][$index]['max_mark'] = $getStandardSubjectInfo->max_mark;
                        $standardSubjectData['examConfig'][$index]['pass_mark'] = $getStandardSubjectInfo->pass_mark;
                    }else{
                        $standardSubjectData['examConfig'][$index]['config_display_name'] = '';
                        $standardSubjectData['examConfig'][$index]['subject_part'] = '';
                        $standardSubjectData['examConfig'][$index]['priority'] = '';
                        $standardSubjectData['examConfig'][$index]['conversion'] = 'NO';
                        $standardSubjectData['examConfig'][$index]['conversion_value'] = '';
                        $standardSubjectData['examConfig'][$index]['max_mark'] = '';
                        $standardSubjectData['examConfig'][$index]['pass_mark'] = '';
                    }
                }
            }

            $standardSubjectData['subjectParts'] = $subjectParts;
            $standardSubjectData['gradeTemplate'] = $gradeTemplate;
            // dd($standardSubjectData);
            return $standardSubjectData;
        }
    }
?>
