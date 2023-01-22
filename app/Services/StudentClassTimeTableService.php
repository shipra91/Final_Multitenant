<?php
    namespace App\Services;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\ClassTimeTableSettingsRepository;
    use App\Repositories\ClassTimeTableRepository;
    use App\Repositories\ClassTimeTableDetailRepository;
    use App\Repositories\StandardSubjectRepository;
    use App\Repositories\PeriodRepository;
    use App\Repositories\InstitutionSubjectRepository;
    use App\Repositories\StaffRepository;
    use App\Repositories\RoomMasterRepository;
    use App\Services\InstitutionStandardService;
    use App\Services\InstitutionSubjectService;

    class StudentClassTimeTableService {

        public function getStudentTimeTableData($studentId, $institutionId , $academicYear, $allSessions){

            $studentId = $allSessions['userId'];
            $studentMappingRepository = new StudentMappingRepository();
            $classTimeTableRepository = new ClassTimeTableRepository();
            $classTimeTableDetailRepository = new ClassTimeTableDetailRepository();
            $classTimeTableSettingsRepository = new ClassTimeTableSettingsRepository();
            $standardSubjectRepository = new StandardSubjectRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $periodRepository = new PeriodRepository();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $subjectService = new SubjectService();
            $roomMasterRepository = new RoomMasterRepository();
            $staffRepository = new StaffRepository();

            $studentSubjects = array();

            $daysArray = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $periodData = $periodRepository->getPeriodTypeWise($allSessions);

            $classTimetableDetalsArray['days'] = $daysArray;
            $classTimetableDetalsArray['periodData'] = $periodData;

            $studentData = $studentMappingRepository->fetchStudent($studentId, $allSessions);
            $idStandard = $studentData->id_standard;
            $classTimetableDetalsArray['student_name'] = $studentMappingRepository->getFullName($studentData->name, $studentData->middle_name, $studentData->last_name);

            $data['standardId'] = $idStandard;
            $data['studentId'] = $studentId;

            $standardSubjects = $standardSubjectRepository->fetchStandardSubjects($idStandard, $allSessions);
            foreach($standardSubjects as $subject){
                $institutionSubjectId = $subject->id_institution_subject;
                $institutionSubjectData = $institutionSubjectRepository->find($institutionSubjectId);
                $subjectTypeDetails = $subjectService->fetchSubjectTypeDetails($institutionSubjectData->id_subject, $allSessions);
                if($subjectTypeDetails != 'common'){
                    
                    $data['subjectId'] = $institutionSubjectId;
                    $checkStudentSubject = $studentMappingRepository->checkSubjectMappedToStudent($data, $allSessions);
                    if($checkStudentSubject){
                        array_push($studentSubjects, $institutionSubjectId);
                    }

                }else{
                    array_push($studentSubjects, $institutionSubjectId);
                }
            }

            foreach($periodData as $index => $period){

                foreach($daysArray as $key => $day){

                    $classTimetableArray[$index]['timetable'][$key]['day'] = $day;
                    $timeTableData = $classTimeTableRepository->fetchStandardClassTimeTableData($studentSubjects, $idStandard, $day, $period['id'], $institutionId , $academicYear );
                    $roomName = '';
                    if($timeTableData){
                            
                            $staffName = array();
                            $periodDetails = $periodRepository->fetch($timeTableData->id_period);
                            $standardDetails = $institutionStandardService->fetchStandardByUsingId($timeTableData->id_standard);
                            $subjectDetails =  $institutionSubjectService->getSubjectName($timeTableData->id_subject, $allSessions);
                            if($timeTableData->id_room){
                                $roomDetails = $roomMasterRepository->fetch($timeTableData->id_room);
                                $roomName = '( '.$roomDetails->display_name.' )';
                            }
                            $subjectStaff = explode(',', $timeTableData->id_staffs);
                            foreach($subjectStaff as $staffId){
                                $staffData  = $staffRepository->fetch($staffId);
                                array_push($staffName, $staffData->name);
                            }

                            $classTimetableArray[$index]['timetable'][$key]['period']     = $period->name;
                            $classTimetableArray[$index]['timetable'][$key]['standard']   = $standardDetails;
                            $classTimetableArray[$index]['timetable'][$key]['subject']    = $subjectDetails;
                            $classTimetableArray[$index]['timetable'][$key]['start_time'] = $timeTableData->start_time;
                            $classTimetableArray[$index]['timetable'][$key]['end_time']   = $timeTableData->end_time;
                            $classTimetableArray[$index]['timetable'][$key]['room_name']  = $roomName;
                            $classTimetableArray[$index]['timetable'][$key]['staff_name'] = implode(',' , $staffName);
                    }else{
                            $classTimetableArray[$index]['timetable'][$key]['period']     = $period->name;
                            $classTimetableArray[$index]['timetable'][$key]['standard']   = '';
                            $classTimetableArray[$index]['timetable'][$key]['subject']    = '';
                            $classTimetableArray[$index]['timetable'][$key]['start_time'] = '';
                            $classTimetableArray[$index]['timetable'][$key]['end_time']   = '';
                            $classTimetableArray[$index]['timetable'][$key]['room_name']  = '';
                            $classTimetableArray[$index]['timetable'][$key]['staff_name'] = '';
                    }
                }
            }

            $classTimetableDetalsArray['classTimetable'] = $classTimetableArray;
            return $classTimetableDetalsArray;
        }
    }
?>
