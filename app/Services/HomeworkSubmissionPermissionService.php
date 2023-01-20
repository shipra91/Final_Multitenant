<?php 
    namespace App\Services;
    use App\Models\HomeworkSubmissionPermission;
    use App\Repositories\HomeworkSubmissionPermissionRepository;
    use Carbon\Carbon;
    use Session;

    class HomeworkSubmissionPermissionService {
        public function add($permissionData) {

            $homeworkSubmissionPermissionRepository = new HomeworkSubmissionPermissionRepository();
            $resubmissionDate = '';
            $resubmissionTime = '';
            $homeworkId = $permissionData->homework_id;
            $studentId = $permissionData->student_id;
            $resubmissionAllowed = $permissionData->resubmission_allowed;

            if($resubmissionAllowed == 'YES') {
                $resubmissionDate = Carbon::createFromFormat('d/m/Y', $permissionData->resubmission_date)->format('Y-m-d');  
                $resubmissionTime = $permissionData->resubmission_time;
            }

            $permissionDetails = HomeworkSubmissionPermission::where('id_homework',$homeworkId)->where('id_student',$studentId)->first();

            if($permissionDetails) {
                $permissionDelete = $homeworkSubmissionPermissionRepository->delete($permissionDetails->id);
            }

            $details = array(
                'id_homework'=>$homeworkId,
                'id_student'=>$studentId,
                'resubmission_allowed'=>$resubmissionAllowed,
                'resubmission_date'=>$resubmissionDate,
                'resubmission_time'=>$resubmissionTime, 
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );

            $insert = $homeworkSubmissionPermissionRepository->store($details);
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