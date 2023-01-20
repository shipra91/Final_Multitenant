<?php
    namespace App\Repositories;
    use App\Models\Result;
    use App\Models\StudentMapping;
    use App\Interfaces\ResultRepositoryInterface;
    use Session;
    use DB;

    class ResultRepository implements ResultRepositoryInterface{

        public function all(){
            return Result::all();
        }

        public function store($data){
            return $result = Result::create($data);
        }

        // public function fetch($id){
        //     return $result = Result::find($id);
        // }

        public function fetch($paramArray){
            // dd($paramArray);
            // \DB::enableQueryLog();
            $result = Result::where('tbl_result.id_institute', $paramArray['id_institute'])
                            ->where('tbl_result.id_academic_year', $paramArray['id_academic_year'])
                            ->where('tbl_result.id_exam', $paramArray['id_exam'])
                            ->where('tbl_result.id_subject', $paramArray['id_subject'])
                            ->where('tbl_result.id_standard', $paramArray['id_standard'])
                            ->where('tbl_result.id_student', $paramArray['id_student'])
                            ->first();
            // dd(\DB::getQueryLog());
            return $result;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $result = Result::find($id)->delete();
        }

        public function fetchResultDetail($standardId,$examId,$studentId){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            // DB::enableQueryLog();
            $result = Result::where('id_institute', $institutionId)
                            ->where('id_academic_year', $academicId)
                            ->where('id_standard', $standardId)
                            ->where('id_exam', $examId)
                            ->where('id_student', $studentId)->get();
            //dd(\DB::getQueryLog());
            // dd($result);
            return $result;
        }
    }
