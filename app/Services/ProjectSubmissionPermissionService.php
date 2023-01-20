<?php 
    namespace App\Services;
    use App\Models\ProjectSubmissionPermission;
    use App\Repositories\ProjectSubmissionPermissionRepository;
    use Carbon\Carbon;
    use Session;

    class ProjectSubmissionPermissionService {
        public function add($permissionData) {

            $projectSubmissionPermissionRepository = new ProjectSubmissionPermissionRepository();
            $resubmissionDate = '';
            $resubmissionTime = '';
            $projectId = $permissionData->project_id;
            $studentId = $permissionData->student_id;
            $resubmissionAllowed = $permissionData->resubmission_allowed;

            if($resubmissionAllowed == 'YES') {
                $resubmissionDate = Carbon::createFromFormat('d/m/Y', $permissionData->resubmission_date)->format('Y-m-d');  
                $resubmissionTime = $permissionData->resubmission_time;
            }

            $permissionDetails = ProjectSubmissionPermission::where('id_project',$projectId)->where('id_student',$studentId)->first();

            if($permissionDetails) {
                $permissionDelete = $projectSubmissionPermissionRepository->delete($permissionDetails->id);
            }

            $details = array(
                'id_project'=>$projectId,
                'id_student'=>$studentId,
                'resubmission_allowed'=>$resubmissionAllowed,
                'resubmission_date'=>$resubmissionDate,
                'resubmission_time'=>$resubmissionTime, 
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );

            $insert = $projectSubmissionPermissionRepository->store($details);
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