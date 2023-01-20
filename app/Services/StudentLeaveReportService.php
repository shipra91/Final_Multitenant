<?php
    namespace App\Services;
    use App\Models\StudentLeaveManagement;
    use App\Repositories\StudentLeaveManagementRepository;
    use App\Repositories\StudentRepository;
    use Carbon\Carbon;
    use Session;

    class StudentLeaveReportService {

        // Get student leave reports
        public function getReportData($request, $allSessions){
            $studentLeaveManagementRepository = new StudentLeaveManagementRepository();
            $studentRepository = new StudentRepository();

            $leaveApplications = $studentLeaveManagementRepository->leaveReportData($request, $allSessions);
            $leaveDetails = array();

            foreach($leaveApplications as $key => $leaveApplication){

                $leaveDetails[$key] = $leaveApplication;

                $student = $studentRepository->fetch($leaveApplication->id_student);
                $leaveDetails[$key]['student'] = $student->name;
            }

            return $leaveDetails;
        }
    }
?>
