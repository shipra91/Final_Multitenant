<?php
    namespace App\Services;
    use App\Models\Attendance;
    use App\Repositories\AttendanceRepository;
    use App\Repositories\AttendanceReportRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Services\InstitutionStandardService;
    use App\Services\AttendanceSessionService;
    use App\Services\PeriodService;
    use Carbon\Carbon;
    use Session;
    use DB;

    class AttendanceReportService {

        // function callAttendanceProcedure($requestData){

        //     $allSessions = session()->all();
        //     $institutionId = $allSessions['institutionId'];
        //     $academicYear = $allSessions['academicYear'];

        //     $standardId = $requestData->standard;
        //     $fromDate =  Carbon::createFromFormat('d/m/Y', $requestData->from_date)->format('Y-m-d');
        //     $toDate =  Carbon::createFromFormat('d/m/Y', $requestData->to_date)->format('Y-m-d');

        //     $getPost = DB::select(
        //         'CALL get_attendance_monthly_report("'.$standardId.'", "'.$fromDate.'", "'.$toDate.'", "'.$institutionId.'", "'.$academicYear.'")'
        //         );
            
        //     dd($getPost);
        // }

        function getDatesFromRange($start, $end){
            $dates = array($start);
            
            while(end($dates) < $end){
                $dates[] = date('Y-m-d', strtotime(end($dates).' +1 day'));
            }
            return $dates;
        }

        function getReportData($requestData, $allSessions){

            $studentMappingRepository = new StudentMappingRepository();
            $attendanceReportRepository = new AttendanceReportRepository();
            $attendanceSessionService = new AttendanceSessionService();
            $institutionStandardService = new InstitutionStandardService();
            $attendanceRepository = new AttendanceRepository();
            $periodService = new PeriodService();
            
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $attendanceType = $requestData->attendanceType;
            $dateListInFormat = array();

            $standardIds = $requestData->standard;
            $fromDate =  Carbon::createFromFormat('d/m/Y', $requestData->from_date)->format('Y-m-d');
            $toDate =  Carbon::createFromFormat('d/m/Y', $requestData->to_date)->format('Y-m-d');

            $dateList = $this->getDatesFromRange($fromDate, $toDate);
            foreach($dateList as $date){
                $dateListInFormat[] = Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
            }

            // dd($attendanceType);

            switch ($attendanceType) {

                case "periodwise":
                    
                    $allPeriods = $periodService->periodTypeWise();
                    $studentDetailArray = array();
                    $output = array();
                    $index = 0;

                    foreach($standardIds as $standardId){

                        $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standardId, $allSessions);
                        if($studentDetails){
                            foreach($studentDetails as $studentData){

                                $studentDetailArray[$index]['name'] = $studentData['name'];
                                $studentDetailArray[$index]['egenius_uid'] = $studentData['egenius_uid'];
                                $studentDetailArray[$index]['usn'] = $studentData['usn'];
                                $studentDetailArray[$index]['roll_number'] = $studentData['roll_number'];
                                $studentDetailArray[$index]['father_mobile_number'] = $studentData['father_mobile_number'];
                                $studentDetailArray[$index]['standard'] = $institutionStandardService->fetchStandardByUsingId($studentData['id_standard']);
                                
                                $presentCount = 0;
                                $totalCount = 0;
                                $percentage = 0;

                                $studentDetailArray[$index]['attendanceDetail'] = array();
                                foreach($dateList as $date){

                                    foreach($allPeriods as $period){

                                        $studentDetailArray[$index]['attendanceDetail'][$date][$period['id']] = '-';

                                        $attendanceDetails = $attendanceRepository->allPeriodAttendanceData($standardId, $studentData['id_student'], $date, $period['id'], $allSessions);
                                        if($attendanceDetails){

                                            $totalCount++;

                                            if($attendanceDetails->attendance_status === 'PRESENT'){

                                                $studentDetailArray[$index]['attendanceDetail'][$date][$period['id']] = 'P';

                                                $presentCount ++;
                                            }else{
                                                $studentDetailArray[$index]['attendanceDetail'][$date][$period['id']] = 'A';
                                            }
                                        }
                                    }                            
                                } 

                                if($totalCount > 0){
                                    $percentage = ($presentCount/$totalCount) * 100 ;                            
                                }

                                $studentDetailArray[$index]['totalAttendance'] = $totalCount;
                                $studentDetailArray[$index]['totalPresent'] = $presentCount;
                                $studentDetailArray[$index]['percentage'] = $percentage .'%';
                                $index++;
                            }
                        }
                    }
                    
                    $output = array(
                        'studentDetailArray' => $studentDetailArray,
                        'dateList' => $dateListInFormat,
                        'periods' => $allPeriods
                    );

                    return $output;

                    break;

                case "sessionwise":
                    
                    $allSessions = $attendanceSessionService->getAll($allSessions);
                    $studentDetailArray = array();
                    $output = array();
                    $count = 0;

                    foreach($standardIds as $standardId){

                        $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standardId, $allSessions);
                        
                        if($studentDetails){
                            foreach($studentDetails as $studentData){

                                $studentDetailArray[$count]['name'] = $studentData['name'];
                                $studentDetailArray[$count]['egenius_uid'] = $studentData['egenius_uid'];
                                $studentDetailArray[$count]['usn'] = $studentData['usn'];
                                $studentDetailArray[$count]['roll_number'] = $studentData['roll_number'];
                                $studentDetailArray[$count]['father_mobile_number'] = $studentData['father_mobile_number'];
                                $studentDetailArray[$count]['standard'] = $institutionStandardService->fetchStandardByUsingId($studentData['id_standard']);
                                
                                $presentCount = 0;
                                $totalCount = 0;
                                $percentage = 0;

                                $studentDetailArray[$count]['attendanceDetail'] = array();
                                foreach($dateList as $date){

                                    foreach($allSessions as $session){

                                        $studentDetailArray[$count]['attendanceDetail'][$date][$session['id']] = '-';

                                        $attendanceDetails = $attendanceRepository->allPeriodAttendanceData($standardId, $studentData['id_student'], $date, $session['id'], $allSessions);
                                        if($attendanceDetails){

                                            $totalCount++;

                                            if($attendanceDetails->attendance_status === 'PRESENT'){

                                                $studentDetailArray[$count]['attendanceDetail'][$date][$session['id']] = 'P';

                                                $presentCount ++;
                                            }else{
                                                $studentDetailArray[$count]['attendanceDetail'][$date][$session['id']] = 'A';
                                            }
                                        }
                                    }                            
                                } 

                                if($totalCount > 0){
                                    $percentage = ($presentCount/$totalCount) * 100 ;                            
                                }

                                $studentDetailArray[$count]['totalAttendance'] = $totalCount;
                                $studentDetailArray[$count]['totalPresent'] = $presentCount;
                                $studentDetailArray[$count]['percentage'] = $percentage .'%';
                                $count++;
                            }
                        }
                    }
                    
                    $output = array(
                        'studentDetailArray' => $studentDetailArray,
                        'dateList' => $dateListInFormat,
                        'sessions' => $allSessions
                    );

                    return $output;
                    break;

                case "daywise":

                    $studentDetailArray = array();
                    $output = array();
                    $index = 0;

                    foreach($standardIds as $standardId){

                        $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standardId, $allSessions);
                        if($studentDetails){
                            foreach($studentDetails as $studentData){

                                $studentDetailArray[$index]['name'] = $studentData['name'];
                                $studentDetailArray[$index]['egenius_uid'] = $studentData['egenius_uid'];
                                $studentDetailArray[$index]['usn'] = $studentData['usn'];
                                $studentDetailArray[$index]['roll_number'] = $studentData['roll_number'];
                                $studentDetailArray[$index]['father_mobile_number'] = $studentData['father_mobile_number'];
                                $studentDetailArray[$index]['standard'] = $institutionStandardService->fetchStandardByUsingId($studentData['id_standard']);
                                
                                $presentCount = 0;
                                $totalCount = 0;
                                $percentage = 0;

                                $studentDetailArray[$index]['attendanceDetail'] = array();
                                foreach($dateList as $date){

                                    $studentDetailArray[$index]['attendanceDetail'][$date] = '-';

                                    $attendanceDetails = $attendanceRepository->allDayAttendanceData($standardId, $studentData['id_student'], $date, $allSessions);
                                    if($attendanceDetails){

                                        $totalCount++;

                                        if($attendanceDetails->attendance_status === 'PRESENT'){

                                            $studentDetailArray[$index]['attendanceDetail'][$date] = 'P';

                                            $presentCount ++;
                                        }else{
                                            $studentDetailArray[$index]['attendanceDetail'][$date] = 'A';
                                        }
                                    }                     
                                } 

                                if($totalCount > 0){
                                    $percentage = ($presentCount/$totalCount) * 100 ;                            
                                }

                                $studentDetailArray[$index]['totalAttendance'] = $totalCount;
                                $studentDetailArray[$index]['totalPresent'] = $presentCount;
                                $studentDetailArray[$index]['percentage'] = $percentage .'%';
                                $index++;
                            }
                        }
                    }
                    
                    $output = array(
                        'studentDetailArray' => $studentDetailArray,
                        'dateList' => $dateListInFormat
                    );

                    return $output;
                    break;

                default:
                    echo "Your favorite color is neither red, blue, nor green!";
            }   

        }

        function getAbsentReport($requestData, $allSessions){

            $studentMappingRepository = new StudentMappingRepository();
            $attendanceReportRepository = new AttendanceReportRepository();
            $attendanceSessionService = new AttendanceSessionService();
            $institutionStandardService = new InstitutionStandardService();
            $attendanceRepository = new AttendanceRepository();
            $periodService = new PeriodService();
            
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $attendanceType = $requestData->dailyAattendanceType;
            $dateListInFormat = array();

            $standardIds = $requestData->standardIds;
            $date =  Carbon::createFromFormat('d/m/Y', $requestData->from_date)->format('Y-m-d');

            // dd($attendanceType);

            switch ($attendanceType) {

                case "periodwise":
                    
                    $allPeriods = $periodService->periodTypeWise();
                    $studentDetailArray = array();
                    $output = array();
                    $index = 0;

                    foreach($standardIds as $standardId){

                        $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standardId, $allSessions);
                        if($studentDetails){
                            foreach($studentDetails as $studentData){
                                
                                $absentCount = 0;
                                $studentDetailArray[$index]['studentDetail'] = array();
                                
                                $studentDetailArray[$index]['attendanceDetail'] = array();

                                foreach($allPeriods as $period){

                                    $studentDetailArray[$index]['attendanceDetail'][$date][$period['id']] = '-';

                                    $attendanceDetails = $attendanceRepository->allPeriodAttendanceData($standardId, $studentData['id_student'], $date, $period['id'], $allSessions);
                                    if($attendanceDetails){

                                        if($attendanceDetails->attendance_status === 'ABSENT'){
                                            $studentDetailArray[$index]['attendanceDetail'][$date][$period['id']] = 'A';
                                            $absentCount++;
                                        }
                                    }
                                }

                                if($absentCount > 0){
                                    $studentDetailArray[$index]['studentDetail']['name'] = $studentData['name'];
                                    $studentDetailArray[$index]['studentDetail']['egenius_uid'] = $studentData['egenius_uid'];
                                    $studentDetailArray[$index]['studentDetail']['usn'] = $studentData['usn'];
                                    $studentDetailArray[$index]['studentDetail']['roll_number'] = $studentData['roll_number'];
                                    $studentDetailArray[$index]['studentDetail']['father_mobile_number'] = $studentData['father_mobile_number'];
                                    $studentDetailArray[$index]['studentDetail']['standard'] = $institutionStandardService->fetchStandardByUsingId($studentData['id_standard']);                     
                                }
                                $index++;
                            }
                        }
                    }
                    // dd($studentDetailArray);
                    $output = array(
                        'studentDetailArray' => $studentDetailArray,
                        'date' => $date,
                        'periods' => $allPeriods
                    );

                    return $output;

                    break;

                case "sessionwise":
                    
                    $allSessions = $attendanceSessionService->getAll($allSessions);
                    $studentDetailArray = array();
                    $output = array();
                    $index = 0;

                    foreach($standardIds as $standardId){

                        $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standardId, $allSessions);
                        if($studentDetails){
                            foreach($studentDetails as $studentData){
                                
                                $absentCount = 0;
                                $studentDetailArray[$index]['studentDetail'] = array();
                                
                                $studentDetailArray[$index]['attendanceDetail'] = array();

                                foreach($allSessions as $session){

                                    $studentDetailArray[$index]['attendanceDetail'][$date][$session['id']] = '-';

                                    $attendanceDetails = $attendanceRepository->allPeriodAttendanceData($standardId, $studentData['id_student'], $date, $session['id'], $allSessions);
                                    if($attendanceDetails){

                                        if($attendanceDetails->attendance_status === 'ABSENT'){
                                            $studentDetailArray[$index]['attendanceDetail'][$date][$session['id']] = 'A';
                                            $absentCount++;
                                        }
                                    }
                                }

                                if($absentCount > 0){
                                    $studentDetailArray[$index]['studentDetail']['name'] = $studentData['name'];
                                    $studentDetailArray[$index]['studentDetail']['egenius_uid'] = $studentData['egenius_uid'];
                                    $studentDetailArray[$index]['studentDetail']['usn'] = $studentData['usn'];
                                    $studentDetailArray[$index]['studentDetail']['roll_number'] = $studentData['roll_number'];
                                    $studentDetailArray[$index]['studentDetail']['father_mobile_number'] = $studentData['father_mobile_number'];
                                    $studentDetailArray[$index]['studentDetail']['standard'] = $institutionStandardService->fetchStandardByUsingId($studentData['id_standard']);                     
                                }
                                $index++;
                            }
                        }
                    }
                    
                    $output = array(
                        'studentDetailArray' => $studentDetailArray,
                        'date' => $date,
                        'sessions' => $allSessions
                    );

                    return $output;
                    break;

                case "daywise":

                    $studentDetailArray = array();
                    $output = array();
                    $index = 0;

                    foreach($standardIds as $standardId){

                        $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standardId, $allSessions);
                        if($studentDetails){
                            foreach($studentDetails as $studentData){
                                
                                $absentCount = 0;
                                $studentDetailArray[$index]['studentDetail'] = array();
                                
                                $studentDetailArray[$index]['attendanceDetail'] = array();

                                $attendanceDetails = $attendanceRepository->allDayAttendanceData($standardId, $studentData['id_student'], $date, $allSessions);
                                if($attendanceDetails){

                                    if($attendanceDetails->attendance_status === 'ABSENT'){
                                        $studentDetailArray[$index]['attendanceDetail'] = 'A';
                                        $absentCount++;
                                    }
                                }                  

                                if($absentCount > 0){
                                    $studentDetailArray[$index]['studentDetail']['name'] = $studentData['name'];
                                    $studentDetailArray[$index]['studentDetail']['egenius_uid'] = $studentData['egenius_uid'];
                                    $studentDetailArray[$index]['studentDetail']['usn'] = $studentData['usn'];
                                    $studentDetailArray[$index]['studentDetail']['roll_number'] = $studentData['roll_number'];
                                    $studentDetailArray[$index]['studentDetail']['father_mobile_number'] = $studentData['father_mobile_number'];
                                    $studentDetailArray[$index]['studentDetail']['standard'] = $institutionStandardService->fetchStandardByUsingId($studentData['id_standard']);                     
                                }
                                $index++;
                            }
                        }
                    }
                    
                    $output = array(
                        'studentDetailArray' => $studentDetailArray,
                        'date' => $date
                    );
                    // dd($output);
                    return $output;
                    break;

                default:
                    echo "Your favorite color is neither red, blue, nor green!";
            }   

        }
        
    }
?>