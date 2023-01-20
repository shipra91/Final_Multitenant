<?php 
    namespace App\Services;
    use App\Models\AssignmentViewedDetails;
    use App\Repositories\AssignmentViewedDetailsRepository;
    use Carbon\Carbon;
    use Session;

    class AssignmentViewedDetailsService 
    {
        public function updateViewStatus($data) {
            $assignmentViewedDetailsRepository = new AssignmentViewedDetailsRepository();

            $idStudent = $data['id_student'];
            $idAssignment = $data['id_assignment'];
            $viewCount = 1;
            $assignmentViewDetails = $assignmentViewedDetailsRepository->fetch($data);
            if($assignmentViewDetails)
            {
                $viewCount = $assignmentViewDetails->view_count;
                $updateViewCount = $viewCount + 1;
                $assignmentViewDetails->id_assignment = $idAssignment;
                $assignmentViewDetails->id_student = $idStudent;
                $assignmentViewDetails->view_count = $updateViewCount;
                $assignmentViewDetails->modified_by = Session::get('userId');
                $assignmentViewDetails->updated_at = Carbon::now();             
                $updateData = $assignmentViewedDetailsRepository->update($assignmentViewDetails);

            }
            else
            {
                $viewData = array(
                    'id_assignment' => $idAssignment, 
                    'id_student' => $idStudent, 
                    'view_count' => $viewCount,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );
                $insertData = $assignmentViewedDetailsRepository->store($viewData);
            }

        }

    }
?>