<?php
    namespace App\Repositories;
    use App\Models\AssignmentSubmissionPermission;
    use App\Interfaces\AssignmentSubmissionPermissionRepositoryInterface;

    class AssignmentSubmissionPermissionRepository implements AssignmentSubmissionPermissionRepositoryInterface{

        public function all(){
            return AssignmentSubmissionPermission::all();
        }

        public function store($data){
            return $assignmentSubmissionPermission = AssignmentSubmissionPermission::create($data);
        }

        public function fetch($data){
            $idStudent = $data['id_student'];
            $idAssignment = $data['id_assignment'];
            return $assignmentSubmissionPermission = AssignmentSubmissionPermission::where('id_assignment', $idAssignment)->where('id_student', $idStudent)->withTrashed()->orderBy('created_at', 'ASC')->get();
        }

        public function fetchData($id){
            return AssignmentSubmissionPermission::find($id);
        } 

        public function fetchActiveDetails($data){
            $idStudent = $data['id_student'];
            $idAssignment = $data['id_assignment'];
            return $assignmentSubmissionPermission = AssignmentSubmissionPermission::where('id_assignment', $idAssignment)->where('id_student', $idStudent)->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return AssignmentSubmissionPermission::find($id)->delete();
        }
    }