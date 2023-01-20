<?php
    namespace App\Services;
    use App\Models\Attendance;
    use App\Services\QuickAttendanceService;
    use App\Services\InstitutionStandardService;
    use App\Services\StandardSubjectService;
    use App\Repositories\QuickAttendanceRepository;
    use App\Repositories\AttendanceSessionRepository;
    use App\Repositories\PeriodRepository;
    use App\Repositories\StudentRepository;
    use App\Repositories\StudentMappingRepository;
    use Carbon\Carbon;
    use Session;

    class QuickAttendanceService {

        public function getAll(){

            $quickAttendanceRepository = new QuickAttendanceRepository();
            $quickAttendance = $quickAttendanceRepository->all();

            return $quickAttendance;
        }

        public function getAttendanceData(){

            $attendanceSessionRepository = new AttendanceSessionRepository();
            $periodRepository = new PeriodRepository();

            $sessions = $attendanceSessionRepository->all();
            $period = $periodRepository->getPeriodTypeWise();

            $output = array(
                'sessions' => $sessions,
                'period' => $period,
            );
            return $output;
        }

        public function getSubjectStandards($request){

            $standardSubjectService =  new StandardSubjectService();
            $institutionStandardService =  new InstitutionStandardService();
            $standardsDetails = array();

            $standards = $standardSubjectService->getStandardForSubjects($request->subjectId, $request->attendanceType);

            foreach($standards as $index => $data) {
                $standardsDetails[$index]['id_standard'] = $data->id_standard;
                $standardsDetails[$index]['standard'] =  $institutionStandardService->fetchStandardByUsingId($data->id_standard);
            }

            return $standardsDetails;
        }

        public function add($attendanceData){

            $quickAttendanceRepository = new QuickAttendanceRepository();
            $studentRepository = new StudentRepository();

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $count = 0;

            $attendanceType = $attendanceData->attendanceType;
            $idSubject = $attendanceData->subject;
            $studentIds = $attendanceData->student;
            $periodSession = $attendanceData->period;
            $heldOn = Carbon::createFromFormat('d/m/Y', $attendanceData->attendanceDate)->format('Y-m-d');
            $idStaff =  Session::get('userId');
            $term = '';
            $details[1] = $attendanceData->standard_id;
            $details[2] = $attendanceData->subject;

            if($idSubject != ''){

                $students = $studentRepository->fetchStudentBySubject($details);

            }else{

                $students = $studentRepository->fetchStudentByStandard($details);
            }

            foreach($students as $student){

                $idStudent = $student->id;

                if(in_array($idStudent, $studentIds)) {

                    $attendanceStatus = 'ABSENT';

                }else{

                    $attendanceStatus = 'PRESENT';
                }

                $check = Attendance::where('id_academic_year', $academicYear)->where('held_on', $heldOn)->where('id_subject', $idSubject)->where('id_student', $idStudent)->first();

                if(!$check){

                    $data = array(
                        'id_institute' => $institutionId,
                        'id_academic_year' => $academicYear,
                        'id_attendance_type' => $attendanceType,
                        'id_standard' => $student->id_standard,
                        'id_subject' => $idSubject,
                        'id_student' => $idStudent,
                        'id_staff' => Session::get('userId'),
                        'period_session' => $periodSession,
                        'held_on' => $heldOn,
                        'attendance_status' => $attendanceStatus,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                    );

                    $store = $quickAttendanceRepository->store($data);

                    if($store){
                        $count = $count+1;
                    }

                }else{

                    $attendanceId  = $check->id;
                    $data = $quickAttendanceRepository->fetch($attendanceId);
                    $data->attendance_status = $attendanceStatus;
                    $data->modified_by = Session::get('userId');
                    $data->updated_at = Carbon::now();

                    $update = $quickAttendanceRepository->update($data);

                    if($update){
                        $count = $count+1;
                    }
                }
            }

            if($count > 0){
                $signal = 'success';
                $msg = 'Data updated successfully!';

            }else {
                $signal = 'failure';
                $msg = 'Error updating data!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function getAbsentStudents(){

            $quickAttendanceRepository = new QuickAttendanceRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $institutionStandardService = new InstitutionStandardService();
            $absentDetails = array();
            $quickAttendance = $quickAttendanceRepository->fetchAbsentStudents();

            foreach($quickAttendance as $attendance){

                $standard = $institutionStandardService->fetchStandardByUsingId($attendance->id_standard);
                $student = $studentMappingRepository->fetchStudent($attendance->id_student);
                $absentDetails[] = array(
                    'id'=>$attendance->id_student,
                    'idAttendance'=>$attendance->id,
                    'uid'=>$student->egenius_uid,
                    'standard'=>$standard,
                    'student_name'=>$student->name,
                    'phone'=>$student->father_mobile_number
                );
            }

            return $absentDetails;
        }

        public function update($details, $id){

            $quickAttendanceRepository = new QuickAttendanceRepository();
            $attendance_status = 'PRESENT';

            $data = $quickAttendanceRepository->fetch($id);

            $data->attendance_status = $attendance_status;
            $data->modified_by = Session::get('userId');
            $data->updated_at = Carbon::now();

            $update = $quickAttendanceRepository->update($data);

            if($update){
                $signal = 'success';
                $msg = 'Data updated successfully!';

            }else {
                $signal = 'failure';
                $msg = 'Error updating data!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
