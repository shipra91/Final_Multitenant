<?php
    namespace App\Repositories;
    use App\Models\ProjectSubmissionDetail;
    use App\Interfaces\ProjectSubmissionDetailRepositoryInterface;
    use DB;

    class ProjectSubmissionDetailRepository implements ProjectSubmissionDetailRepositoryInterface{

        public function all(){
            return ProjectSubmissionDetail::all();
        }

        public function store($data){
            return $projectSubmissionDetail = ProjectSubmissionDetail::create($data);
        }

        public function fetch($data) {
            //DB::enableQueryLog();
            $idStudent = $data['id_student'];
            $idProject = $data['id_project'];
            return ProjectSubmissionDetail::join('tbl_project_submission', 'tbl_project_submission.id', '=', 'tbl_project_submission_details.id_project_submission')
            ->where('tbl_project_submission.id_student', $idStudent)
            ->where('tbl_project_submission.id_project', $idProject)
            ->select('tbl_project_submission_details.*')->get();

            //dd(DB::getQueryLog());
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $projectSubmissionDetail = ProjectSubmissionDetail::find($id)->delete();
        }
    }