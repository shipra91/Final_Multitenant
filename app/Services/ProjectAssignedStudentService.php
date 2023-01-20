<?php 
    namespace App\Services;
    use App\Models\ProjectAssignedStudents;
    use App\Repositories\ProjectAssignedStudentsRepository;
    use Carbon\Carbon;
    use Session;

    class ProjectAssignedStudentService 
    {
        public function updateViewStatus($data) {
            $projectAssignedStudentsRepository = new ProjectAssignedStudentsRepository();
            $viewCount = 1;
          
            $projectViewDetails = $projectAssignedStudentsRepository->fetchStudentProject($data);
           
            if($projectViewDetails)
            {
                $viewCount = $projectViewDetails->view_count;
                $updateViewCount = $viewCount + 1;
                $projectViewDetails->view_count = $updateViewCount;
                $projectViewDetails->modified_by = Session::get('userId');
                $projectViewDetails->updated_at = Carbon::now();             
                $updateData = $projectAssignedStudentsRepository->update($projectViewDetails);
            }
        }
    }
?>