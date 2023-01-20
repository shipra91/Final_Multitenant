<?php
    namespace App\Repositories;
    use App\Models\AssignmentViewedDetails;
    use App\Interfaces\AssignmentViewedDetailsRepositoryInterface;

    class AssignmentViewedDetailsRepository implements AssignmentViewedDetailsRepositoryInterface{

        public function all(){
            return AssignmentViewedDetails::all();
        }

        public function store($data){
            return $assignmentViewedDetails = AssignmentViewedDetails::create($data);
        }

        public function fetch($data){
            $idStudent = $data['id_student'];
            $idAssignment = $data['id_assignment'];
            return $assignmentViewedDetails = AssignmentViewedDetails::where('id_assignment', $idAssignment)->where('id_student', $idStudent)->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($data){
            $idStudent = $data['id_student'];
            $idAssignment = $data['id_assignment'];
            
            return AssignmentViewedDetails::where('id_assignment', $idAssignment)->where('id_student', $idStudent)->delete();
        }
    }