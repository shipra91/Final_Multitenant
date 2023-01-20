<?php 
    namespace App\Services;
    use App\Models\HomeworkViewedDetails;
    use App\Repositories\HomeworkViewedDetailsRepository;
    use Carbon\Carbon;
    use Session;

    class HomeworkViewedDetailsService 
    {
        public function updateViewStatus($data) {
            $homeworkViewedDetailsRepository = new HomeworkViewedDetailsRepository();

            $idStudent = $data['id_student'];
            $idHomework = $data['id_homework'];
            $viewCount = 1;
            $homeworkViewDetails = $homeworkViewedDetailsRepository->fetch($data);
            if($homeworkViewDetails)
            {
                $viewCount = $homeworkViewDetails->view_count;
                $updateViewCount = $viewCount + 1;
                $homeworkViewDetails->id_homework = $idHomework;
                $homeworkViewDetails->id_student = $idStudent;
                $homeworkViewDetails->view_count = $updateViewCount;
                $homeworkViewDetails->modified_by = Session::get('userId');
                $homeworkViewDetails->updated_at = Carbon::now();             
                $updateData = $homeworkViewedDetailsRepository->update($homeworkViewDetails);

            }
            else
            {
                $viewData = array(
                    'id_homework' => $idHomework, 
                    'id_student' => $idStudent, 
                    'view_count' => $viewCount,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );
                $insertData = $homeworkViewedDetailsRepository->store($viewData);
            }

        }

    }
?>