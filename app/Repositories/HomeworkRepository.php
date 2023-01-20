<?php
    namespace App\Repositories;
    use App\Models\Homework;
    use App\Interfaces\HomeworkRepositoryInterface;
    use Session;

    class HomeworkRepository implements HomeworkRepositoryInterface{

        public function all(){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            
            return Homework::where('id_institute', $institutionId)
              ->where('id_academic', $academicId)->orderBy('created_at', 'ASC')->get();
        }

        public function store($data){
            return $homework = Homework::create($data);
        }

        public function fetch($id){
            return $homework = Homework::find($id);
        } 
        public function fetchHomeworkUsingStaff($idStaff){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            
            return $homework = Homework::where('id_institute', $institutionId)
            ->where('id_academic', $academicId)->where('id_staff', $idStaff)
            ->get();
        } 

        public function fetchHomeworkByStandard($idStandard){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return $homework = Homework::where('id_institute', $institutionId)
                                            ->where('id_academic', $academicId)
                                            ->where('id_standard', $idStandard)
                                            ->get();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $homework = Homework::find($id)->delete();
        }

        public function allDeleted(){
            return Homework::onlyTrashed()->get();
        }        

        public function restore($id){
            return Homework::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return Homework::onlyTrashed()->restore();
        }
    }