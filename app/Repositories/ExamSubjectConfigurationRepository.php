<?php
    namespace App\Repositories;
    use App\Models\ExamSubjectConfiguration;
    use App\Interfaces\ExamSubjectConfigurationRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class ExamSubjectConfigurationRepository implements ExamSubjectConfigurationRepositoryInterface{

        public function all(){
            $allSessions = session()->all();
            $idInstitution = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            return ExamSubjectConfiguration::where('id_institute', $idInstitution)
                        ->where('id_academic', $academicYear)
                        ->get();
        }

        public function store($data){
            return $event = ExamSubjectConfiguration::create($data);
        }

        public function search($idAttendance){
            return ExamSubjectConfiguration::where('id', $idAttendance)->first();
        }

        public function fetch($id){
            $event = ExamSubjectConfiguration::find($id);
            return $event;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $event = ExamSubjectConfiguration::find($id)->delete();
        }

        public function allDeleted(){
            return ExamSubjectConfiguration::onlyTrashed()->get();
        }

        public function restore($id){
            return ExamSubjectConfiguration::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return ExamSubjectConfiguration::onlyTrashed()->restore();
        }

        public function checkExistence($examId, $standardId, $subjectId, $allSessions){
            
            $idInstitution = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $check = ExamSubjectConfiguration::where('id_institute', $idInstitution)
                        ->where('id_academic', $academicYear)
                        ->where('id_exam', $examId)
                        ->where('id_standard', $standardId)
                        ->where('id_subject', $subjectId)
                        ->first();

            return $check;
        }

        public function getExamStandardConfiguration($examId, $standardId, $subjectId, $allSessions){

            DB::enableQueryLog();
            
            $idInstitution = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $check = ExamSubjectConfiguration::where('id_institute', $idInstitution)
                        ->where('id_academic', $academicYear)
                        ->where('id_exam', $examId)
                        ->where('id_standard', $standardId)
                        ->where('id_subject', $subjectId)
                        ->first();
            // dd(DB::getQueryLog());
            return $check;
        }

        public function getExamSubjectConfig($examId, $standardId, $allSessions){
            
            $idInstitution = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $configData = ExamSubjectConfiguration::where('id_institute', $idInstitution)
                        ->where('id_academic', $academicYear)
                        ->where('id_exam', $examId)
                        ->where('id_standard', $standardId)
                        ->get();

            return $configData;
        }

        public function getExamStandardGrade($examId, $standardId, $allSessions){
            
            $idInstitution = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $configData = ExamSubjectConfiguration::where('id_institute', $idInstitution)
                        ->where('id_academic', $academicYear)
                        ->where('id_exam', $examId)
                        ->where('id_standard', $standardId)
                        ->first();

            return $configData;
        }
    }
