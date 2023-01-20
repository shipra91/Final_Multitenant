<?php
    namespace App\Services;

    use App\Models\Grade;
    use App\Models\GradeDetail;
    use App\Repositories\GradeRepository;
    use App\Repositories\GradeDetailRepository;
    use Carbon\Carbon;
    use Session;

    class GradeDetailService {

        // Delete grade detail
        public function delete($id){

            $gradeDetailRepository = new GradeDetailRepository();
            $gradeDetails = $gradeDetailRepository->delete($id);

            if($gradeDetails){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
