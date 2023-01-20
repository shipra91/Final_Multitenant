<?php
    namespace App\Repositories;
    use App\Models\HomeworkSubmissionDetail;
    use App\Interfaces\HomeworkSubmissionDetailRepositoryInterface;
    use DB;

    class HomeworkSubmissionDetailRepository implements HomeworkSubmissionDetailRepositoryInterface{

        public function all(){
            return HomeworkSubmissionDetail::all();
        }

        public function store($data){
            return $homeworkSubmissionDetail = HomeworkSubmissionDetail::create($data);
        }

        public function fetch($data) {
            //DB::enableQueryLog();
            $idStudent = $data['id_student'];
            $idHomework = $data['id_homework'];
            return HomeworkSubmissionDetail::join('tbl_homework_submission', 'tbl_homework_submission.id', '=', 'tbl_homework_submission_details.id_homework_submission')
            ->where('tbl_homework_submission.id_student', $idStudent)
            ->where('tbl_homework_submission.id_homework', $idHomework)
            ->select('tbl_homework_submission_details.*')->get();

            //dd(DB::getQueryLog());
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $homeworkSubmissionDetail = HomeworkSubmissionDetail::find($id)->delete();
        }
    }