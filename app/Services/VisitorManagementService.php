<?php
    namespace App\Services;
    use App\Models\VisitorManagement;
    use App\Repositories\VisitorManagementRepository;
    use Carbon\Carbon;
    use Session;
    use DB;

    class VisitorManagementService {

        // Get all visitor
        public function getAll($request, $allSessions){

            $visitorManagementRepository = new VisitorManagementRepository();

            $output = $visitorManagementRepository->all($request, $allSessions);
            return $output;
        }

        // Insert visitor
        public function add($requestData){

            $institutionId = $requestData->id_institute;
            $academicYear = $requestData->id_academic;

            $visitorManagementRepository = new VisitorManagementRepository();

            $data = array(
                'id_institute' => $institutionId,
                'id_academic_year' => $academicYear,
                'type' => $requestData->visitor_type,
                'visitor_name' => $requestData->full_name,
                'visitor_contact' => $requestData->visitor_phone,
                'visitor_age' => $requestData->visitor_age,
                'visitor_address' => $requestData->visitor_address,
                'gender' => $requestData->visitor_gender,
                'person_to_meet' => $requestData->person_to_meet,
                'concerned_person' => $requestData->other_person,
                'visit_purpose' => $requestData->visit_purpose,
                'visitor_type' => $requestData->visitorType,
                'visitor_type_name' => $requestData->other_type,
                'visiting_datetime' => Carbon::createFromFormat('d/m/Y H:i:s', $requestData->meeting_date)->format('Y-m-d H:i:s'),
                'visiting_status' => "PENDING",
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );

            $storeData = $visitorManagementRepository->store($data);

            if($storeData){
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

        // Get particular visitor
        public function fetch($id){

            $visitorManagementRepository = new VisitorManagementRepository();

            $visitorData = $visitorManagementRepository->fetch($id);
            $visitorData['startTime'] = Carbon::createFromFormat('Y-m-d H:i:s', $visitorData->visiting_datetime)->format('d/m/Y H:i:s');
            return $visitorData;
        }

        // Update visitor
        public function update($requestData, $id){

            $visitorManagementRepository = new VisitorManagementRepository();
            $visitorData = $visitorManagementRepository->fetch($id);

            $visitorData->type = $requestData->visitor_type;
            $visitorData->visitor_name = $requestData->full_name;
            $visitorData->visitor_contact = $requestData->visitor_phone;
            $visitorData->visitor_age = $requestData->visitor_age;
            $visitorData->visitor_address = $requestData->visitor_address;
            $visitorData->gender = $requestData->visitor_gender;
            $visitorData->person_to_meet = $requestData->person_to_meet;
            $visitorData->concerned_person = $requestData->other_person;
            $visitorData->visit_purpose = $requestData->visit_purpose;
            $visitorData->visitor_type = $requestData->visitorType;
            $visitorData->visitor_type_name = $requestData->other_type;
            $visitorData->visiting_datetime = Carbon::createFromFormat('d/m/Y H:i:s', $requestData->meeting_date)->format('Y-m-d H:i:s');
            $visitorData->modified_by = Session::get('userId');
            $visitorData->updated_at = Carbon::now();


            $storeData = $visitorManagementRepository->update($visitorData);

            if($storeData){
                $signal = 'success';
                $msg = 'Data updated successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error updating data!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Delete visitor
        public function delete($id){

            $visitorManagementRepository = new VisitorManagementRepository();

            $visitor = $visitorManagementRepository->delete($id);

            if($visitor){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Deleted visitor records
        public function getDeletedRecords($allSessions){

            $visitorManagementRepository = new VisitorManagementRepository();

            $output = $visitorManagementRepository->allDeleted($allSessions);
            return $output;
        }

        // Restore visitor records
        public function restore($id){

            $visitorManagementRepository = new VisitorManagementRepository();

            $visitor = $visitorManagementRepository->restore($id);

            if($visitor){

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

        // Cancel visitor meeting
        public function cancelVisit($requestData, $id){

            $visitorManagementRepository = new VisitorManagementRepository();

            $visitorData = $visitorManagementRepository->fetch($id);
            $visitorData->cancellation_reason = $requestData->cancelled_reason;
            $visitorData->cancelled_date = Carbon::createFromFormat('d/m/Y H:i:s', $requestData->cancelled_date)->format('Y-m-d H:i:s');
            $visitorData->visiting_status = 'CANCELLED';
            $visitorData->cancelled_by = Session::get('userId');

            $storeData = $visitorManagementRepository->update($visitorData);

            if($storeData){
                $signal = 'success';
                $msg = 'Meeting cancelled successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error updating data!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Complete visitor meeting
        public function meetingComplete($requestData, $id){

            $visitorManagementRepository = new VisitorManagementRepository();

            $visitorData = $visitorManagementRepository->fetch($id);
            $visitorData->end_datetime = Carbon::now();
            $visitorData->visiting_status = 'SUCCESS';

            $storeData = $visitorManagementRepository->update($visitorData);

            if($storeData){
                $signal = 'success';
                $msg = 'Meeting marked as complete successfully!';

            }else{
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
?>
