<?php
    namespace App\Repositories;
    use App\Models\ExamMaster;
    use App\Interfaces\ExamMasterRepositoryInterface;
    use Session;
    use DB;

    class ExamMasterRepository implements ExamMasterRepositoryInterface{

        public function all(){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return ExamMaster::where('id_institute', $institutionId)->where('id_academic_year', $academicId)->get();
        }

        public function store($data){
            return ExamMaster::create($data);
        }

        public function fetch($id){
           return ExamMaster::find($id);
        }

        public function fetchData($standardId){
           return ExamMaster::where('id_standard', $standardId)->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return ExamMaster::delete($id);
        }

        public function updateExamMaster($data, $id){
            return ExamMaster::whereId($id)->update($data);
        }

        public function fetchExamMaster($idInstitutionStandard){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return ExamMaster::where('id_standard', $idInstitutionStandard)->where('id_institute', $institutionId)->where('id_academic_year', $academicId)->get();
        }

        public function fetchExamByStandard($standardId){
            \DB::enableQueryLog();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $exam = ExamMaster::Select('tbl_exam_master.*')
                    ->join('tbl_exam_timetable_setting', 'tbl_exam_timetable_setting.id_exam', '=', 'tbl_exam_master.id')
                    ->join('tbl_exam_timetable', 'tbl_exam_timetable.id_exam_timetable_setting', '=', 'tbl_exam_timetable_setting.id')
                    ->where('tbl_exam_timetable_setting.id_standard', $standardId)
                    ->where('tbl_exam_timetable_setting.id_institute', $institutionId)
                    ->where('tbl_exam_timetable_setting.id_academic_year', $academicId)
                    ->groupBy('tbl_exam_timetable_setting.id_exam')
                    ->get();
            // dd(\DB::getQueryLog());

            return $exam;
        }
    }
?>
