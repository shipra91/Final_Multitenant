<?php
    namespace App\Services;
    use App\Models\EventAttendance;
    use App\Repositories\EventAttendanceRepository;
    use App\Repositories\EventRecipientRepository;
    use App\Repositories\StaffRepository;
    use App\Repositories\StudentRepository;
    use Session;

    class EventAttendanceService {

        // Get event recipient
        public function getEventRecipients($eventId){

            $eventRecipientRepository = new EventRecipientRepository();
            $eventAttendanceRepository = new EventAttendanceRepository();
            $staffRepository = new StaffRepository();
            $studentRepository = new StudentRepository();

            $recepientData = $eventRecipientRepository->getEventRecipient($eventId);

            $recepientDetail = array();
            $attendanceStatus = "PRESENT";

            foreach($recepientData as $key => $recepient){

                $status = $eventAttendanceRepository->fetch($eventId, $recepient->id_recipient);

                if($status){
                    $attendanceStatus = $status->attendance_status;
                }

                if($recepient->recipient_type == 'STUDENT'){

                    $studentName = '';

                    $student = $studentRepository->fetch($recepient->id_recipient);

                    if($student){
                        $studentName = $student->name;
                    }

                    $recepientDetail[$key] = $recepient;
                    $recepientDetail[$key]['name'] = $studentName;

                }else{

                    $staffName = '';

                    $staff = $staffRepository->fetch($recepient->id_recipient);

                    if($staff){
                        $staffName = $staff->name;
                    }

                    $recepientDetail[$key] = $recepient;
                    $recepientDetail[$key]['name'] = $staffName;
                }

                if($recepient->recipient_type == 'STUDENT'){
                    $recipientType = 'Student';
                }else{
                    $recipientType = 'Staff';
                }

                $recepientDetail[$key]['status'] = $attendanceStatus;
                $recepientDetail[$key]['recipientType'] = $recipientType;
            }

            return $recepientDetail;
        }

        // Insert event attendance
        public function add($attendanceData){

            $eventAttendanceRepository = new EventAttendanceRepository();

            $idEvent = $attendanceData->eventId;
            $recepientType = $attendanceData->recepientType;
            $idRecepients = $attendanceData->recepientId;
            $count = 0;
            //dd($attendanceData);

            foreach($idRecepients as $key => $idRecepient){

                $count++;
                $status = $attendanceData->status[$idRecepient];
                $check = $eventAttendanceRepository->fetch($idEvent, $idRecepient);

                if(!$check){

                    // insert
                    $data = array(
                        'id_event' => $idEvent,
                        'recipient_type' => $recepientType[$key],
                        'id_recipient' => $idRecepient,
                        'attendance_status' => $status,
                        'created_by' => Session::get('userId')
                    );

                    $storeData = $eventAttendanceRepository->store($data);

                }else{

                    // update
                    $attendanceId = $check->id;
                    $attendanceDetail = $eventAttendanceRepository->search($attendanceId);

                    $attendanceDetail->attendance_status = $status;
                    $attendanceDetail->modified_by = Session::get('userId');
                    $storeData = $eventAttendanceRepository->update($attendanceDetail);
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
