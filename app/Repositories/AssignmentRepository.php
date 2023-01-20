<?php
    namespace App\Repositories;
    use App\Models\Assignment;
    use App\Interfaces\AssignmentRepositoryInterface;
    use Session;

    class AssignmentRepository implements AssignmentRepositoryInterface{

        public function all(){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return Assignment::where('id_institute', $institutionId)
              ->where('id_academic', $academicId)->orderBy('created_at', 'ASC')->get();
        }

        public function store($data){
            return $assignment = Assignment::create($data);
        }

        public function fetch($id){
            return $assignment = Assignment::find($id);
        } 
        public function fetchAssignmentUsingStaff($idStaff){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return $assignment = Assignment::where('id_institute', $institutionId)
            ->where('id_academic', $academicId)->where('id_staff', $idStaff)->get();
        } 

        public function fetchAssignmentByStandard($idStandard){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return $assignment = Assignment::where('id_institute', $institutionId)
                                            ->where('id_academic', $academicId)
                                            ->where('id_standard', $idStandard)
                                            ->get();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $assignment = Assignment::find($id)->delete();
        }

        public function allDeleted(){
            return Assignment::onlyTrashed()->get();
        }        

        public function restore($id){
            return Assignment::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return Assignment::onlyTrashed()->restore();
        }
    }