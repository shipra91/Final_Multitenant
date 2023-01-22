<?php
    namespace App\Repositories;
    use App\Models\ExamTimetable;
    use App\Interfaces\ExamTimetableRepositoryInterface;
    use Session;
    use DB;

    class ExamTimetableRepository implements ExamTimetableRepositoryInterface{

        // public function all(){
        //     $allSessions = session()->all();
        //     $institutionId = $allSessions['institutionId'];
        //     $academicId = $allSessions['academicYear'];
        //     return ExamTimetable::where('id_institute', $institutionId)->where('id_academic_year', $academicId)->get();
        // }

        public function all(){
            //\DB::enableQueryLog();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $examTimetable = ExamTimetable::join('tbl_exam_timetable_setting', 'tbl_exam_timetable_setting.id', '=', 'tbl_exam_timetable.id_exam_timetable_setting')
                        ->where('tbl_exam_timetable_setting.id_institute', $institutionId)
                        ->where('tbl_exam_timetable_setting.id_academic_year', $academicId)
                        ->select('tbl_exam_timetable.*')->get();
            //dd(\DB::getQueryLog());
            return $examTimetable;
        }

        public function getExamMinMax($request, $allSessions){
            //\DB::enableQueryLog();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $examId = $request['examId'];
            $standardId = $request['standardId'];

            $examTimetable = ExamTimetable::select(\DB::raw('SUM(tbl_exam_timetable.max_marks) as maxMark, SUM(tbl_exam_timetable.min_marks) as minMark'))
                        ->join('tbl_exam_timetable_setting', 'tbl_exam_timetable_setting.id', '=', 'tbl_exam_timetable.id_exam_timetable_setting')
                        ->where('tbl_exam_timetable_setting.id_institute', $institutionId)
                        ->where('tbl_exam_timetable_setting.id_academic_year', $academicId)
                        ->where('tbl_exam_timetable_setting.id_exam', $examId)
                        ->where('tbl_exam_timetable_setting.id_standard', $standardId)
                        ->first();
            //dd(\DB::getQueryLog());
            return $examTimetable;
        }

        public function store($data){
            return ExamTimetable::create($data);
        }

        public function find($idExamTimetableSetting){
            return ExamTimetable::where('id_exam_timetable_setting', $idExamTimetableSetting)->first();
        }

        public function fetch($examId, $idSubject, $standardId){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return ExamTimetable::join('tbl_exam_timetable_setting', 'tbl_exam_timetable_setting.id', '=', 'tbl_exam_timetable.id_exam_timetable_setting')
                        ->where('tbl_exam_timetable.id_institution_subject', $idSubject)
                        ->where('tbl_exam_timetable_setting.id_exam', $examId)
                        ->where('tbl_exam_timetable_setting.id_standard', $standardId)
                        ->where('tbl_exam_timetable_setting.id_institute', $institutionId)
                        ->where('tbl_exam_timetable_setting.id_academic_year', $academicId)
                        ->select('tbl_exam_timetable.*')->first();

        }

        public function fetchExamSubjects($request, $allSessions){
            $standardId = $request['standardId'];
            $examId = $request['examId'];

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return ExamTimetable::join('tbl_exam_timetable_setting', 'tbl_exam_timetable_setting.id', '=', 'tbl_exam_timetable.id_exam_timetable_setting')
                            ->where('tbl_exam_timetable_setting.id_exam', $examId)
                            ->where('tbl_exam_timetable_setting.id_standard', $standardId)
                            ->where('tbl_exam_timetable_setting.id_institute', $institutionId)
                            ->where('tbl_exam_timetable_setting.id_academic_year', $academicId)
                            ->select('tbl_exam_timetable.*')->get();

        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return ExamTimetable::delete($id);
        }

        // public function fetchExamTimetable($idInstitutionStandard){
        //     return ExamTimetable::where('id_standard', $idInstitutionStandard)->get();
        // }

        public function updateExamTimetable($data, $id){
            return ExamTimetable::whereId($id)->update($data);
        }

        public function fetchSubjectsByExam($standardId, $examId, $allSessions){
            //\DB::enableQueryLog();

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $subjects = ExamTimetable::join('tbl_exam_timetable_setting', 'tbl_exam_timetable_setting.id', '=', 'tbl_exam_timetable.id_exam_timetable_setting')
                        ->where('tbl_exam_timetable_setting.id_exam', $examId)
                        ->where('tbl_exam_timetable_setting.id_standard', $standardId)
                        ->where('tbl_exam_timetable_setting.id_institute', $institutionId)
                        ->where('tbl_exam_timetable_setting.id_academic_year', $academicId)
                        ->select('tbl_exam_timetable.*')->get();
            //dd(\DB::getQueryLog());
            return $subjects;
        }
    }
?>