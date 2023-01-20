<?php 
    namespace App\Services;
    use App\Models\ExamTimetable;
    use App\Models\ExamTimetableSetting;
    use App\Services\SubjectService;
    use App\Repositories\ExamTimetableRepository;
    use App\Repositories\ExamTimetableSettingRepository;
    use App\Repositories\InstitutionSubjectRepository;
    use App\Repositories\StandardSubjectRepository;
    use App\Repositories\ExamMasterRepository;
    use App\Services\InstitutionStandardService;
    use App\Services\StandardSubjectService;
    use Session;
    use Carbon\Carbon;

    class ExamTimetableService 
    {
        public function add($examTimetableData){

            $standardSubjectService =  new StandardSubjectService();
            $examTimetableRepository = new ExamTimetableRepository();
            $examTimetableSettingRepository = new ExamTimetableSettingRepository();
           
            $allSessions = session()->all();
            $institutionId = $examTimetableData->id_institute;
            $academicYear = $examTimetableData->id_academic;

            $idStandards = explode(',',$examTimetableData->id_standard);
            $idExam = $examTimetableData->id_exam;
            $timetableType = $examTimetableData->timetable_type;
            // dd($examTimetableData);
            if($timetableType == 'classwise')
            {
                foreach($idStandards as $idStandard)
                {
                    $check = ExamTimetableSetting::where('id_academic_year', $academicYear)
                                    ->where('id_institute', $institutionId)
                                    ->where('id_exam', $idExam)
                                    ->where('id_standard', $idStandard)
                                    ->first();
                    if(!$check)
                    {
                        $data = array( 
                        'id_academic_year' => $academicYear,
                        'id_institute' => $institutionId,
                        'id_exam' => $idExam,
                        'timetable_type' => $timetableType,
                        'id_standard' => $idStandard,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                        );
                        $store = $examTimetableSettingRepository->store($data);
                        $idExamTimetableSetting = $store->id;
                    }
                    else
                    {
                        $idExamTimetableSetting = $check->id;
                    }

                    foreach($examTimetableData->subject_ids[$idStandard] as $key => $subjectId) 
                    {
                        $subjectCheckVal = 'check_'.$idStandard.'_'.$subjectId;
                        $examDateVal = 'exam_date_'.$idStandard.'_'.$subjectId;
                        $durationVal = 'duration_in_min_'.$idStandard.'_'.$subjectId;
                        $startTimeVal = 'start_time_'.$idStandard.'_'.$subjectId;
                        $maxMarksVal = 'max_marks_'.$idStandard.'_'.$subjectId;
                        $minMarksVal = 'min_marks_'.$idStandard.'_'.$subjectId;
                        if(isset($examTimetableData->$subjectCheckVal))
                        {
                            $examDate = Carbon::createFromFormat('d/m/Y', $examTimetableData->$examDateVal)->format('Y-m-d');
                            $durationInMin = $examTimetableData->$durationVal;
                            $startTime = $examTimetableData->$startTimeVal;
                            $maxMarks = $examTimetableData->$maxMarksVal;
                            $minMarks = $examTimetableData->$minMarksVal;
                            $durationInSec = $durationInMin * 60;
                            $endTime = strtotime($startTime) + (int) $durationInSec;
                            $endTime =  date('h:i A', $endTime);
                          
                            if($idExamTimetableSetting)
                            {
                                $check = ExamTimetable::where('id_exam_timetable_setting', $idExamTimetableSetting)
                                    ->where('id_institution_subject', $subjectId)->first();
                                if(!$check)
                                {
                                    $data = array( 
                                    'id_exam_timetable_setting' => $idExamTimetableSetting,
                                    'id_institution_subject' => $subjectId,
                                    'exam_date' => $examDate,
                                    'duration_in_min' => $durationInMin,
                                    'start_time' => $startTime,
                                    'end_time' => $endTime,
                                    'max_marks' => $maxMarks,
                                    'min_marks' => $minMarks,
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                    );
                                    $storeData = $examTimetableRepository->store($data);
                                   
                                }
                                else
                                {
                                    $updateData = $examTimetableRepository->find($idExamTimetableSetting);
                                    $updateData->exam_date = $examDate;
                                    $updateData->duration_in_min = $durationInMin;
                                    $updateData->start_time = $startTime;
                                    $updateData->end_time = $endTime;
                                    $updateData->max_marks = $maxMarks;
                                    $updateData->min_marks = $minMarks;
                                    $updateData->modified_by = Session::get('userId');
                                    $updateData->updated_at = Carbon::now();
                                    $update = $examTimetableRepository->update($updateData);
                                }
                            }
                        }
                    }
                }    
            }
            else
            {
                foreach($examTimetableData->subject_id as $subjectId)
                {
                    foreach($examTimetableData->standard_ids[$subjectId] as $idStandard)
                    {
                        $check = ExamTimetableSetting::where('id_academic_year', $academicYear)
                                        ->where('id_institute', $institutionId)
                                        ->where('id_exam', $idExam)
                                        ->where('id_standard', $idStandard)
                                        ->first();
                        if(!$check)
                        {
                            $data = array( 
                            'id_academic_year' => $academicYear,
                            'id_institute' => $institutionId,
                            'id_exam' => $idExam,
                            'timetable_type' => $timetableType,
                            'id_standard' => $idStandard,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                            );
                            $store = $examTimetableSettingRepository->store($data);
                            $idExamTimetableSetting = $store->id;
                        }
                        else
                        {
                            $idExamTimetableSetting = $check->id;
                        }
                        $standardCheckVal = 'check_'.$idStandard.'_'.$subjectId;
                        $examDateVal = 'exam_date_'.$idStandard.'_'.$subjectId;
                        $durationVal = 'duration_in_min_'.$idStandard.'_'.$subjectId;
                        $startTimeVal = 'start_time_'.$idStandard.'_'.$subjectId;
                        $maxMarksVal = 'max_marks_'.$idStandard.'_'.$subjectId;
                        $minMarksVal = 'min_marks_'.$idStandard.'_'.$subjectId;

                        if(isset($examTimetableData->$standardCheckVal))
                        {
                            $examDate = Carbon::createFromFormat('d/m/Y',$examTimetableData->$examDateVal)->format('Y-m-d');
                            $durationInMin = $examTimetableData->$durationVal;
                            $startTime = $examTimetableData->$startTimeVal;
                            $maxMarks = $examTimetableData->$maxMarksVal;
                            $minMarks = $examTimetableData->$minMarksVal;
                            $durationInSec = $durationInMin * 60;
                            $endTime = strtotime($startTime) + (int) $durationInSec;
                            $endTime =  date('h:i A', $endTime);
                            
                            if($idExamTimetableSetting)
                            {
                                $check = ExamTimetable::where('id_exam_timetable_setting', $idExamTimetableSetting)
                                    ->where('id_institution_subject', $subjectId)->first();
                                if(!$check)
                                {
                                    $data = array( 
                                    'id_exam_timetable_setting' => $idExamTimetableSetting,
                                    'id_institution_subject' => $subjectId,
                                    'exam_date' => $examDate,
                                    'duration_in_min' => $durationInMin,
                                    'start_time' => $startTime,
                                    'end_time' => $endTime,
                                    'max_marks' => $maxMarks,
                                    'min_marks' => $minMarks,
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                    );
                                    $storeData = $examTimetableRepository->store($data);
                                }
                                else
                                {
                                    $updateData = $examTimetableRepository->find($idExamTimetableSetting);
                                    $updateData->exam_date = $examDate;
                                    $updateData->duration_in_min = $durationInMin;
                                    $updateData->start_time = $startTime;
                                    $updateData->end_time = $endTime;
                                    $updateData->max_marks = $maxMarks;
                                    $updateData->min_marks = $minMarks;
                                    $updateData->modified_by = Session::get('userId');
                                    $updateData->updated_at = Carbon::now();
                                    $update = $examTimetableRepository->update($updateData);
                                }
                            }
                        }
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

        public function find($request, $allSessions)
        {
            $standardIds = $request->get('standard');
            $examId = $request->get('exam');
            $timetableType = $request->get('timetable_type');
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $examTimetableRepository = new ExamTimetableRepository();
            $examMasterRepository = new ExamMasterRepository();
            $standardSubjectService =  new StandardSubjectService();
            $standardSubjectRepository =  new StandardSubjectRepository(); 
            
            $examDetails =  $examMasterRepository->fetch($examId);
            $examStandardIds = explode(',', $examDetails->id_standard);
            // dd($examStandardIds);
            $fromDate = Carbon::createFromFormat('Y-m-d', $examDetails->from_date)->format('d/m/Y');
            $toDate = Carbon::createFromFormat('Y-m-d', $examDetails->to_date)->format('d/m/Y');

            if($timetableType == 'classwise') {
                $examTimetableDetails = array();

                foreach ($standardIds as $key => $standardId) {

                    $examTimetableDetails[$key]['subjectArray'] = array();

                    $standardSubjectDetails = $standardSubjectService->fetchStandardSubjects($standardId, $allSessions);
                    // dd($standardSubjectDetails);
                    $examTimetableSetting['setting']['from_date'] =  $fromDate;
                    $examTimetableSetting['setting']['to_date'] =  $toDate;
                    $examTimetableSetting['setting']['standard'] =  implode(',' , $standardIds);
                    $examTimetableSetting['setting']['exam'] =  $examId;
                    $examTimetableSetting['setting']['timetable_type'] =  $timetableType;

                    $className = $institutionStandardService->fetchStandardByUsingId($standardId);

                    $examTimetableDetails[$key]['standard_id'] = $standardId;
                    $examTimetableDetails[$key]['class_name'] = $className;

                    if(count($standardSubjectDetails) > 0) {
                        foreach($standardSubjectDetails as $index => $subject) {
                            $examTimetableData =  $examTimetableRepository->fetch($examId, $subject['id'], $standardId);
                            // dd($examTimetableData);
                            $examTimetableDetails[$key]['subjectArray'][$index]['subject_name'] =  $subject['name'];
                            $examTimetableDetails[$key]['subjectArray'][$index]['subject_id'] =  $subject['id'];

                            if($examTimetableData) {
                                $examDate = Carbon::createFromFormat('Y-m-d', $examTimetableData->exam_date)->format('d/m/Y');
                                $examTimetableDetails[$key]['subjectArray'][$index]['check'] = 'checked';
                                $examTimetableDetails[$key]['subjectArray'][$index]['exam_date'] = $examDate;
                                $examTimetableDetails[$key]['subjectArray'][$index]['duration_in_min'] = $examTimetableData->duration_in_min;
                                $examTimetableDetails[$key]['subjectArray'][$index]['start_time'] = $examTimetableData->start_time;
                                $examTimetableDetails[$key]['subjectArray'][$index]['max_marks'] = $examTimetableData->max_marks;
                                $examTimetableDetails[$key]['subjectArray'][$index]['min_marks'] = $examTimetableData->min_marks;
                            
                            } else {  
                                $examTimetableDetails[$key]['subjectArray'][$index]['check'] = '';
                                $examTimetableDetails[$key]['subjectArray'][$index]['exam_date'] = $fromDate;
                                $examTimetableDetails[$key]['subjectArray'][$index]['duration_in_min'] = '';
                                $examTimetableDetails[$key]['subjectArray'][$index]['start_time'] = '';
                                $examTimetableDetails[$key]['subjectArray'][$index]['max_marks'] = '';
                                $examTimetableDetails[$key]['subjectArray'][$index]['min_marks']= '';
                            } 
                        } 
                    }
                    // else
                    // {
                    //     $examTimetableDetails[$key]['subjectArray'][0]['subject_name'] = '';
                    //     $examTimetableDetails[$key]['subjectArray'][0]['subject_id'] = '';
                    //     $examTimetableDetails[$key]['subjectArray'][0]['check'] = '';
                    //     $examTimetableDetails[$key]['subjectArray'][0]['exam_date'] = '';
                    //     $examTimetableDetails[$key]['subjectArray'][0]['duration_in_min'] = '';
                    //     $examTimetableDetails[$key]['subjectArray'][0]['start_time'] = '';
                    //     $examTimetableDetails[$key]['subjectArray'][0]['max_marks'] = '';
                    //     $examTimetableDetails[$key]['subjectArray'][0]['min_marks']= '';
                        
                    // }
                    $standardExamDetails['class_wise'] = $examTimetableDetails;
                }

                $examSettingDetails = array(
                    'class_wise' =>$standardExamDetails['class_wise'],
                    'setting'=>$examTimetableSetting['setting']
                );

            }else{

                $examTimetableSetting['setting']['from_date'] =  $fromDate;
                $examTimetableSetting['setting']['to_date'] =  $toDate;
                $examTimetableSetting['setting']['exam'] =  $examId;
                $examTimetableSetting['setting']['timetable_type'] =  $timetableType;

                $institutionSubjects =  $institutionSubjectRepository->all($allSessions);

                foreach($institutionSubjects as $key => $subjectData){

                    $subjectCount = $institutionSubjectRepository->findCount($subjectData->id_subject, $allSessions);
    
                    if(sizeof($subjectCount) == 2){
                        $displayName = $subjectData['display_name'].'-'.$subjectData['subject_type'];
                    }else{
                        $displayName= $subjectData['display_name'];
                    }

                    $standardIds =  $standardSubjectRepository->fetchSubjectStandards($subjectData->id);
                    // dd($standardIds);

                    if($standardIds){
                        
                        foreach($standardIds as $index => $standardId){

                            if(in_array($standardId->id_standard, $examStandardIds)){

                                $examTimetableDetails[$key]['subject_id'] = $subjectData->id;
                                $examTimetableDetails[$key]['subject_name'] = $displayName;

                                $classNames = $institutionStandardService->fetchStandardByUsingId($standardId->id_standard);
                                $examTimetableData =  $examTimetableRepository->fetch($examId, $subjectData->id, $standardId->id_standard);
                            
                                if($examTimetableData){

                                    $examDate = Carbon::createFromFormat('Y-m-d', $examTimetableData->exam_date)->format('d/m/Y');
                                    $examTimetableDetails[$key]['classArray'][$index]['standard_id'] = $standardId->id_standard;
                                    $examTimetableDetails[$key]['classArray'][$index]['class'] = $classNames;
                                    $examTimetableDetails[$key]['classArray'][$index]['check'] = 'checked';
                                    $examTimetableDetails[$key]['classArray'][$index]['exam_date'] = $examDate;
                                    $examTimetableDetails[$key]['classArray'][$index]['duration_in_min'] = $examTimetableData->duration_in_min;
                                    $examTimetableDetails[$key]['classArray'][$index]['start_time'] = $examTimetableData->start_time;
                                    $examTimetableDetails[$key]['classArray'][$index]['max_marks'] = $examTimetableData->max_marks;
                                    $examTimetableDetails[$key]['classArray'][$index]['min_marks'] = $examTimetableData->min_marks;
                                }else{  
                                    
                                    $examTimetableDetails[$key]['classArray'][$index]['standard_id'] = $standardId->id_standard;
                                    $examTimetableDetails[$key]['classArray'][$index]['class'] = $classNames;
                                    $examTimetableDetails[$key]['classArray'][$index]['check'] = '';
                                    $examTimetableDetails[$key]['classArray'][$index]['exam_date'] = $fromDate;
                                    $examTimetableDetails[$key]['classArray'][$index]['duration_in_min'] = '';
                                    $examTimetableDetails[$key]['classArray'][$index]['start_time'] = '';
                                    $examTimetableDetails[$key]['classArray'][$index]['max_marks'] = '';
                                    $examTimetableDetails[$key]['classArray'][$index]['min_marks']= '';
                                } 
                            }
                        }
                    }
                }
                
                $examSettingDetails = array(
                    'subject_wise' =>$examTimetableDetails,
                    'setting'=>$examTimetableSetting['setting']
                );
            } 

            // dd($examSettingDetails);
            return $examSettingDetails;
        }

        public function fetchExamSubjects($request, $allSessions)
        { 
            
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $examTimetableRepository = new ExamTimetableRepository();
            $allSubjectDetails = array();

            $examSubjectDetails =  $examTimetableRepository->fetchExamSubjects($request, $allSessions);

            foreach($examSubjectDetails as $key => $subject){
               
                $subjectData = $institutionSubjectRepository->find($subject->id_institution_subject);
                $subjectCount = $institutionSubjectRepository->findCount($subjectData->id_subject, $allSessions);
 
                if(sizeof($subjectCount) == 2)
                {
                    $displayName = $subjectData['display_name'].'-'.$subjectData['subject_type'];
                }
                else
                {
                    $displayName= $subjectData['display_name'];
                }

                $allSubjectDetails[$key]['id'] = $subject->id_institution_subject;
                $allSubjectDetails[$key]['name'] = $displayName;
            }
         
            return $allSubjectDetails;
        }
        
        public function getExamWithTimetable($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            
            $data = ExamTimetableSetting::join('tbl_exam_master', 'tbl_exam_master.id', '=', 'tbl_exam_timetable_setting.id_exam')
                ->where('tbl_exam_timetable_setting.id_institute', $institutionId)
                ->where('tbl_exam_timetable_setting.id_academic_year', $academicYear)
                ->select('tbl_exam_master.name', 'tbl_exam_timetable_setting.*')
                ->groupBy('tbl_exam_timetable_setting.id_exam')
                ->get();

            return $data;
        }
    }