<?php
    namespace App\Repositories;
    use App\Models\AssignmentSubmission;
    use App\Interfaces\AssignmentSubmissionRepositoryInterface;

    class AssignmentSubmissionRepository implements AssignmentSubmissionRepositoryInterface{

        public function all(){
            return AssignmentSubmission::all();
        }

        public function store($data){
            return $assignmentSubmission = AssignmentSubmission::create($data);
        }

        public function fetch($data){
            $idStudent = $data['id_student'];
            $idAssignment = $data['id_assignment'];
            return $assignmentSubmission = AssignmentSubmission::where('id_assignment', $idAssignment)->where('id_student', $idStudent)->withTrashed()->orderBy('created_at', 'ASC')->get();
        }

        public function fetchData($id){
            return AssignmentSubmission::find($id);
        } 

        public function fetchActiveDetails($data){
            $idStudent = $data['id_student'];
            $idAssignment = $data['id_assignment'];
            return $assignmentSubmission = AssignmentSubmission::where('id_assignment', $idAssignment)->where('id_student', $idStudent)->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($data){
            $idStudent = $data['id_student'];
            $idAssignment = $data['id_assignment'];
            
            return AssignmentSubmission::where('id_assignment', $idAssignment)->where('id_student', $idStudent)->delete();
        }
    }