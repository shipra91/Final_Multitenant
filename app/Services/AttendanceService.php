<?php
    namespace App\Services;

    use App\Models\Attendance;
    use App\Repositories\AttendanceRepository;
    use App\Repositories\StudentRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Services\InstitutionStandardService;
    use Carbon\Carbon;
    use Session;

    class AttendanceService {

        // Get all standard
        public function getStandard(){

            $institutionStandardService = new InstitutionStandardService();
            $institutionStandards = $institutionStandardService->fetchStandard();

            return $institutionStandards;
        }

        // View student attendance
        public function getAll($request, $allSessions){

            $attendanceRepository = new AttendanceRepository();
            $attendanceDetails = $attendanceRepository->fetchAttendanceDetail($request, $allSessions);
            // dd($attendanceDetails);
            $studentData = array();

            foreach($attendanceDetails as $key => $attendanceDetail){

                $studentData[$key] = $attendanceDetail;
                $attendanceStatus = array();

                $attendanceStatusData = $attendanceRepository->fetchAttendanceStatus($attendanceDetail->id_student, $attendanceDetail->held_on, $attendanceDetail->id_standard, $allSessions);

                if($attendanceStatusData){
                    foreach($attendanceStatusData as $status){
                        array_push($attendanceStatus, $status['attendance_status']);
                    }
                }else{
                    array_push($attendanceStatus, 'NIL');
                }
                $percentage = $totalWorkingDays = $totalPresentDays = 0;

                $workingDays = $attendanceRepository->fetchWorkingDays($attendanceDetail->id, $allSessions);
                // dd($workingDays);

                if($workingDays){
                    $totalWorkingDays = $workingDays;
                }

                $presentDays = $attendanceRepository->fetchPresentDays($attendanceDetail->id, $allSessions);

                if($workingDays){
                    $totalPresentDays = $presentDays;
                }

                if($totalPresentDays > 0){
                    $percentage = round((100*$totalPresentDays)/$totalWorkingDays);
                }

                $studentData[$key]['workingDays'] = $totalWorkingDays;
                $studentData[$key]['presentDays'] = $totalPresentDays;
                $studentData[$key]['percentage'] = $percentage.'%';
                $studentData[$key]['attendanceStatus'] = $attendanceStatus;
            }
            // dd($studentData);
            return $studentData;
        }

        // Get all student attendance
        public function getAttendanceStudent($request, $allSessions){

            $attendanceRepository = new AttendanceRepository();
            $studentRepository = new StudentRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $attendanceStatus = 'PRESENT';

            $standardId = $request->get('standard');
            $attendanceType = $request->get('attendanceType');

            if($attendanceType === 'daywise'){

                $periodSession = '';
                $subjectId = '';

            }else if($attendanceType === 'periodwise'){

                $periodSession = $request->get('period');
                $subjectId = $request->get('subject');

            }else if($attendanceType === 'sessionwise'){

                $periodSession = $request->get('session');
                $subjectId = '';
            }

            $requestData = array(
                'standardId' => $standardId,
                'subjectId' => $subjectId
            );

            $heldOn = $request->get('attendance_date');
            $heldOn = Carbon::createFromFormat('d/m/Y', $heldOn)->format('Y-m-d');

            if($attendanceType === 'periodwise'){
                $studentData = $studentMappingRepository->fetchStudentUsingSubject($requestData, $allSessions);
                //dd($studentData);
            }else{
                $studentData = $studentMappingRepository->fetchSessionStudentUsingStandard($request, $allSessions);
            }
            // dd($studentData);
            foreach($studentData as $key => $student){

                $studentDetails = $studentRepository->fetch($student->id_student);

                $studentAttendance = $attendanceRepository->fetch($student->id_student, $heldOn, $standardId, $subjectId, $attendanceType, $periodSession, $allSessions);

                if($studentAttendance){
                    $attendanceStatus = $studentAttendance->attendance_status;
                }
                // dd($attendanceStatus);

                $studentData[$key] = $studentDetails;
                $studentData[$key]['attendanceStatus'] = $attendanceStatus;
            }
            // dd($studentData);
            return $studentData;
        }

        // Insert student attendance
        public function add($attendanceData, $allSessions){

            $attendanceRepository = new AttendanceRepository();
            $heldOn = Carbon::createFromFormat('d/m/Y', $attendanceData->date)->format('Y-m-d');
            $idInstitute = $attendanceData->idInstitute;
            $academicYear = $attendanceData->idAcademic;
            $standardId = $attendanceData->standard;
            $subjectId = $attendanceData->subject;
            $attendanceType = $attendanceData->attendanceType;
            $periodSession = $attendanceData->periodSession;

            $count = 0;
            //dd($attendanceData);

            foreach($attendanceData['status'] as $key => $status){

                $count++;

                $check = $attendanceRepository->fetch($key, $heldOn, $standardId, $subjectId, $attendanceType, $periodSession, $allSessions);

                if(!$check){

                    // Insert attendance
                    $data = array(
                        'id_institute' => $idInstitute,
                        'id_academic_year' => $academicYear,
                        'id_standard' => $standardId,
                        'id_subject' => $subjectId,
                        'id_student' => $key,
                        'id_staff' => Session::get('userId'),
                        'id_attendance_type' => $attendanceType,
                        'period_session' => $periodSession,
                        'held_on' => $heldOn,
                        'attendance_status' => $status,
                        'created_by' => Session::get('userId')
                    );

                    $storeData = $attendanceRepository->store($data);

                }else{

                    // Update attendance
                    $attendanceId = $check->id;
                    $attendanceData = $attendanceRepository->search($attendanceId);

                    $attendanceData->attendance_status = $status;
                    $attendanceData->modified_by = Session::get('userId');

                    $storeData = $attendanceRepository->update($attendanceData);
                }
            }

            if($count > 0){
                $signal = 'success';
                $msg = 'Data inserted successfully!';

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
    }
?>
