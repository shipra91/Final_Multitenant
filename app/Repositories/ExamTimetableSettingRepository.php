<?php 
    namespace App\Repositories;
    use App\Models\ExamTimetableSetting;
    use App\Interfaces\ExamTimetableSettingRepositoryInterface;
    use Session;

    class ExamTimetableSettingRepository implements ExamTimetableSettingRepositoryInterface{

        public function all(){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return ExamTimetableSetting::where('id_institute', $institutionId)->where('id_academic_year', $academicId)->get();
        }

        public function store($data){
            return ExamTimetableSetting::create($data);
        }        

        public function fetch($id){
           return ExamTimetableSetting::find($id);
        }        

        public function update($data){
            return $data->save();
        }   

        public function delete($id){
            return ExamTimetableSetting::delete($id);
        }

        // public function fetchExamTimetableSetting($idInstitutionStandard){
        //     return ExamTimetableSetting::where('id_standard', $idInstitutionStandard)->get();
        // }  

        public function updateExamTimetableSetting($data, $id){
            return ExamTimetableSetting::whereId($id)->update($data);
        } 
    }
?>