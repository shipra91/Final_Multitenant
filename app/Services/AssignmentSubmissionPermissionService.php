<?php 
    namespace App\Services;
    use App\Models\AssignmentSubmissionPermission;
    use App\Repositories\AssignmentSubmissionPermissionRepository;
    use Carbon\Carbon;
    use Session;

    class AssignmentSubmissionPermissionService {
        public function add($permissionData) {

            $assignmentSubmissionPermissionRepository = new AssignmentSubmissionPermissionRepository();
            $resubmissionDate = '';
            $resubmissionTime = '';
            $assignmentId = $permissionData->assignment_id;
            $studentId = $permissionData->student_id;
            $resubmissionAllowed = $permissionData->resubmission_allowed;

            if($resubmissionAllowed == 'YES') {
                $resubmissionDate = Carbon::createFromFormat('d/m/Y', $permissionData->resubmission_date)->format('Y-m-d');  
                $resubmissionTime = $permissionData->resubmission_time;
            }

            $permissionDetails = AssignmentSubmissionPermission::where('id_assignment',$assignmentId)->where('id_student',$studentId)->first();

            if($permissionDetails) {
                $permissionDelete = $assignmentSubmissionPermissionRepository->delete($permissionDetails->id);
            }

            $details = array(
                'id_assignment'=>$assignmentId,
                'id_student'=>$studentId,
                'resubmission_allowed'=>$resubmissionAllowed,
                'resubmission_date'=>$resubmissionDate,
                'resubmission_time'=>$resubmissionTime, 
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );

            $insert = $assignmentSubmissionPermissionRepository->store($details);
            if($insert){
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