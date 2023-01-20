<?php
    namespace App\Repositories;
    use App\Models\AssignmentSubmissionDetail;
    use App\Interfaces\AssignmentSubmissionDetailRepositoryInterface;
    use DB;

    class AssignmentSubmissionDetailRepository implements AssignmentSubmissionDetailRepositoryInterface{

        public function all(){
            return AssignmentSubmissionDetail::all();
        }

        public function store($data){
            return $assignmentSubmissionDetail = AssignmentSubmissionDetail::create($data);
        }

        public function fetch($data) {
            //DB::enableQueryLog();
            $idStudent = $data['id_student'];
            $idAssignment = $data['id_assignment'];
            return AssignmentSubmissionDetail::join('tbl_assignment_submission', 'tbl_assignment_submission.id', '=', 'tbl_assignment_submission_details.id_assignment_submission')
            ->where('tbl_assignment_submission.id_student', $idStudent)
            ->where('tbl_assignment_submission.id_assignment', $idAssignment)
            ->select('tbl_assignment_submission_details.*')->get();

            //dd(DB::getQueryLog());
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $assignmentSubmissionDetail = AssignmentSubmissionDetail::find($id)->delete();
        }
    }