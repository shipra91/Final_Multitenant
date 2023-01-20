<?php
    namespace App\Repositories;

    use App\Models\Grade;
    use App\Interfaces\GradeRepositoryInterface;
    use Session;

    class GradeRepository implements GradeRepositoryInterface {

        public function all(){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return Grade::where('id_institute', $institutionId)->where('id_academic_year', $academicYear)->get();
        }

        public function store($data){
            return Grade::create($data);
        }

        public function fetch($id){
            return Grade::find($id);
        }

        // public function update($data, $id){
        //     return Document::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return Grade::find($id)->delete();
        }

        public function allDeleted(){
            return Grade::onlyTrashed()->get();
        }

        public function restore($id){
            return Grade::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return Grade::onlyTrashed()->restore();
        }

        public function getGrade($institutionId, $academicYear, $exam, $standardId, $totalPercentage){
            
            $grade = Grade::join('tbl_grade_detail', 'tbl_grade_detail.id_grade', '=', 'tbl_grade.id')
                        ->join('tbl_exam_subject_configuration', 'tbl_exam_subject_configuration.id_grade_set', '=', 'tbl_grade.id')
                        ->where('tbl_grade.id_institute', $institutionId)
                        ->where('tbl_grade.id_academic_year', $academicYear)
                        ->where('tbl_exam_subject_configuration.id_exam', $exam)
                        ->where('tbl_exam_subject_configuration.id_standard', $standardId)
                        ->where('range_from', '<=',$totalPercentage)
                        ->where('range_to', '>=',$totalPercentage)
                        ->first();
            return $grade;
        }
        
    }
