<?php
    namespace App\Services;

    use App\Models\Period;
    use App\Repositories\AttendanceSessionRepository;
    use Session;

    class AttendanceSessionService {

        // Get all session attendance
        public function getAll(){

            $attendanceSessionRepository = New AttendanceSessionRepository();

            $attendanceSession = $attendanceSessionRepository->all();
            return $attendanceSession;
        }

        // Get particular session
        public function find($id){

            $attendanceSessionRepository = New AttendanceSessionRepository();

            $attendanceSession = $attendanceSessionRepository->fetch($id);
            return $attendanceSession;
        }

        // Insert session
        public function add($sessionData){

            $attendanceSessionRepository = New AttendanceSessionRepository();

            $check = Period::where('name', $sessionData->sessionName)->first();

            if(!$check){

                $data = array(
                    'id_institute' => $sessionData->idInstitute,
                    'id_academic_year' => $sessionData->idAcademic,
                    'name' => $sessionData->sessionName,
                    'created_by' => Session::get('userId'),
                    'modified_by' => ''
                );

                $storeData = $attendanceSessionRepository->store($data);

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

        // Delete session
        public function delete($id){

            $attendanceSessionRepository = New AttendanceSessionRepository();

            $period = $attendanceSessionRepository->delete($id);

            if($period){
                $signal = 'success';
                $msg = 'Session Attendance deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Deleted session records
        public function getDeletedRecords(){

            $attendanceSessionRepository = New AttendanceSessionRepository();

            $data = $attendanceSessionRepository->allDeleted();
            return $data;
        }

        // Restore session records
        public function restore($id){

            $attendanceSessionRepository = New AttendanceSessionRepository();

            $data = $attendanceSessionRepository->restore($id);

            if($data){

                $signal = 'success';
                $msg = 'Data restored successfully!';

            }else{

                $signal = 'failure';
                $msg = 'Data deletion is failed!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
