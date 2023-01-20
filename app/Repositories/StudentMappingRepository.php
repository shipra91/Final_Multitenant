<?php
    namespace App\Repositories;
    use App\Models\StudentMapping;
    use App\Interfaces\StudentMappingRepositoryInterface;
    use App\Repositories\InstitutionSubjectRepository;
    use DB;
    use Session;

    class StudentMappingRepository implements StudentMappingRepositoryInterface{

        public function all(){
            return StudentMapping::all();
        }

        public function store($data){
            return StudentMapping::create($data);
        }

        public function getLatestUpdate($idStudent){
            DB::enableQueryLog();
            $lastRecord = StudentMapping::where('id_student', $idStudent)
                                        ->orderBy('updated_at', 'desc')->first();
            // dd(DB::getQueryLog());
            // dd($lastRecord);
            return $lastRecord;
        }

        public function fetch($idStudent, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            
            return StudentMapping::where('id_institute', $institutionId)
                                ->where('id_academic_year', $academicYear)
                                ->where('id_student', $idStudent)->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return StudentMapping::find($id)->delete();
        }

        public function fetchStudentMapping($idStudent){
            return StudentMapping::where('id_student', $idStudent)->get();
        }

        public function fetchInstitutionStudents($standard, $feeType, $gender, $allSessions){

            DB::enableQueryLog();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            // dd($standard);

            $studentDetails = StudentMapping::join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                                ->where('tbl_student_mapping.id_institute', $institutionId)
                                ->where('tbl_student_mapping.id_academic_year', $academicYear);
            // dd($request);

            if($standard){
                $studentDetails = $studentDetails->whereIn('tbl_student_mapping.id_standard', $standard);
                // $standard = implode("','", $standard);
                // $standardList = "'$standard'";
                // dd($standard);
                // foreach($standard as $key => $class){
                //     if($key == 0){
                //         $studentDetails = $studentDetails->where('tbl_student_mapping.id_standard', $class);
                //     }else{
                //         $studentDetails = $studentDetails->orWhere('tbl_student_mapping.id_standard', $class);
                //     }
                // }
            }

            if($gender!=''){
                $studentDetails = $studentDetails->where('id_gender', 'like', '%'.$gender.'%');
            }

            if($feeType!=''){
                $studentDetails = $studentDetails->where('tbl_student_mapping.id_fee_type', 'like', '%'.$feeType.'%');
            }

            $studentDetails = $studentDetails->get(['tbl_student_mapping.*', 'tbl_student.*']);
            // dd(DB::getQueryLog());
            return $studentDetails;
        }

        public function fetchInstitutionStandardStudents($idStandard, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $studentDetails = StudentMapping::join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                                            ->where('tbl_student_mapping.id_institute', $institutionId)
                                            ->where('tbl_student_mapping.id_academic_year', $academicYear)
                                            ->where('tbl_student_mapping.id_standard', $idStandard)
                                            ->get(['tbl_student_mapping.*', 'tbl_student.*']);
            return $studentDetails;
        }

        public function fetchInstitutionPromotionElligibleStudents($idStandard, $allSessions){

            //DB::enableQueryLog();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $studentDetails = StudentMapping::join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                                            ->where('tbl_student_mapping.id_institute', $institutionId)
                                            ->where('tbl_student_mapping.id_academic_year', $academicYear)
                                            ->where('tbl_student_mapping.detention', 'No')
                                            ->where('tbl_student_mapping.id_standard', $idStandard)
                                            ->get(['tbl_student_mapping.*', 'tbl_student.*']);
            return $studentDetails;
        }

        public function fetchInstitutionDetainedStudents($allSessions){

            //DB::enableQueryLog();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $studentDetails = StudentMapping::join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                                            ->where('tbl_student_mapping.id_institute', $institutionId)
                                            ->where('tbl_student_mapping.id_academic_year', $academicYear)
                                            ->where('tbl_student_mapping.detention', 'Yes')
                                            ->get(['tbl_student_mapping.*', 'tbl_student.*']);
            // dd(DB::getQueryLog());
            return $studentDetails;
        }

        public function fetchStudent($id, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            //DB::enableQueryLog();
            $studentDetails = StudentMapping::join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                                            ->where('tbl_student_mapping.id_student', $id)
                                            ->where('tbl_student_mapping.id_institute', $institutionId)
                                            ->where('tbl_student_mapping.id_academic_year', $academicYear)
                                            ->select('tbl_student.*', 'tbl_student_mapping.*')->first();
            //dd(\DB::getQueryLog($studentDetails));
            return $studentDetails;
        }

        public function updateStudentMapping($data){
            return $data->save();
        }

        public function allDeleted($allSessions){

            DB::enableQueryLog();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $deletedData = StudentMapping::onlyTrashed()->join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                                                        ->where('tbl_student_mapping.id_institute', $institutionId)
                                                        ->where('tbl_student_mapping.id_academic_year', $academicYear)
                                                        ->select('tbl_student.*', 'tbl_student_mapping.*', 'tbl_student_mapping.id as id_student_mapping')->get();
            return $deletedData;
            // dd(DB::getQueryLog());
        }

        public function restore($id){
            return StudentMapping::withTrashed()->find($id)->restore();
        }

        public function restoreAll($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return StudentMapping::join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                                ->where('tbl_student_mapping.id_institute', $institutionId)
                                ->where('tbl_student_mapping.id_academic_year', $academicYear)
                                ->onlyTrashed()
                                ->restore();
        }

        public function fetchStudentUsingSubject($request, $allSessions){
            
            DB::enableQueryLog();

            $institutionSubjectRepository = new InstitutionSubjectRepository();

            $standardId = $request['standardId'];
            $subjectId = $request['subjectId'];

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $studentDetails = StudentMapping::join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                            ->leftJoin('tbl_student_electives', 'tbl_student.id', '=', 'tbl_student_electives.id_student')
                            ->join('tbl_standard_subject', 'tbl_standard_subject.id_standard', '=', 'tbl_student_mapping.id_standard')
                            ->where('tbl_student_mapping.id_academic_year', $academicYear)
                            ->where('tbl_student_mapping.id_institute', $institutionId)
                            ->where('tbl_student_mapping.id_standard', $standardId);
                            

            $subjectTypeData = $institutionSubjectRepository->find($subjectId);
            if($subjectTypeData->label == 'common'){
                $studentDetails = $studentDetails->where('tbl_standard_subject.id_institution_subject', $subjectId);
            }else{
                $studentDetails = $studentDetails->where(function($q) use($subjectId){
                                        $q->where('tbl_student_mapping.id_first_language', $subjectId)
                                        ->orWhere('tbl_student_mapping.id_second_language', $subjectId)
                                        ->orWhere('tbl_student_mapping.id_third_language', $subjectId)
                                        ->orWhere('tbl_student_electives.id_elective', $subjectId);
                                    });
            }
            $studentDetails = $studentDetails->select('tbl_student.*', 'tbl_student_mapping.*')
                            ->groupBy('tbl_student_mapping.id_student');
                
            $studentDetails = $studentDetails->get();
            //dd(\DB::getQueryLog());
            return $studentDetails;
        }

        public function fetchStudentUsingStandard($standardId, $allSessions){

            DB::enableQueryLog();

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $studentDetails = StudentMapping::join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                                            ->where('tbl_student_mapping.id_standard', $standardId)
                                            ->where('tbl_student_mapping.id_institute', $institutionId)
                                            ->where('tbl_student_mapping.id_academic_year', $academicYear)
                                            ->select('tbl_student.*', 'tbl_student_mapping.*')->get();
            // dd(\DB::getQueryLog());
            return $studentDetails;
        }        

        public function fetchSessionStudentUsingStandard($request, $allSessions){

            DB::enableQueryLog();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $standardId = $request['standard'];

            $studentDetails = StudentMapping::join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                                            ->where('tbl_student_mapping.id_standard', $standardId)
                                            ->where('tbl_student_mapping.id_institute', $institutionId)
                                            ->where('tbl_student_mapping.id_academic_year', $academicYear)
                                            ->select('tbl_student.*', 'tbl_student_mapping.*')->get();
            // dd(\DB::getQueryLog());
            return $studentDetails;
        }

        public function getStuentsAcademicYear($studentId, $allSessions){

            DB::enableQueryLog();
            
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $studentDetails = StudentMapping::join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                                            ->join('tbl_academic_year_mappings', 'tbl_academic_year_mappings.id', '=', 'tbl_student_mapping.id_academic_year')
                                            ->join('tbl_academic_years', 'tbl_academic_years.id', '=', 'tbl_academic_year_mappings.id_academic_year')
                                            ->where('tbl_student_mapping.id_institute', $institutionId)
                                            ->where('tbl_student.id', $studentId)
                                            ->select('tbl_student_mapping.id_academic_year', 'tbl_academic_years.name')->get();
            // dd(DB::getQueryLog());
            return $studentDetails;
        }

        public function getStudentOnStandard($request, $allSessions){

            DB::enableQueryLog();
            
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $standardIds = $request['standardIds'];

            $studentDetails = StudentMapping::join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                                            ->whereIn('tbl_student_mapping.id_standard', $standardIds)
                                            ->where('tbl_student_mapping.id_institute', $institutionId)
                                            ->where('tbl_student_mapping.id_academic_year', $academicYear)
                                            ->select('tbl_student.*', 'tbl_student_mapping.*')->get();
            // dd(\DB::getQueryLog());
            return $studentDetails;
        }

        public function getStudentOnSubject($request, $allSessions){

            // DB::enableQueryLog();
            $standardIds = $request['standardIds'];
            $subjectId = $request['subjectId'];

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $studentDetails = StudentMapping::join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                                            ->leftJoin('tbl_student_electives', 'tbl_student.id', '=', 'tbl_student_electives.id_student')
                                            ->whereIn('tbl_student_mapping.id_standard', $standardIds)
                                            ->where('tbl_student_mapping.id_institute', $institutionId)
                                            ->where('tbl_student_mapping.id_academic_year', $academicYear)
                                            ->where('tbl_student_mapping.id_first_language', $subjectId)
                                            ->orWhere('tbl_student_mapping.id_second_language', $subjectId)
                                            ->orWhere('tbl_student_mapping.id_third_language', $subjectId)
                                            ->orWhere('tbl_student_electives.id_elective', $subjectId)
                                            ->select('tbl_student.*', 'tbl_student_mapping.*')
                                            ->groupBy('tbl_student_mapping.id_student')->get();
            // dd(\DB::getQueryLog());
            return $studentDetails;
        }

        public function checkSubjectMappedToStudent($data, $allSessions){

            // DB::enableQueryLog();
            $standardId = $data['standardId'];
            $studentId = $data['studentId'];
            $subjectId = $data['subjectId'];
            
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $studentDetails = StudentMapping::join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                                            ->leftJoin('tbl_student_electives', 'tbl_student.id', '=', 'tbl_student_electives.id_student')
                                            ->where('tbl_student_mapping.id_standard', $standardId)
                                            ->where('tbl_student_mapping.id_student', $studentId)
                                            ->where('tbl_student_mapping.id_institute', $institutionId)
                                            ->where('tbl_student_mapping.id_academic_year', $academicYear)
                                            ->where('tbl_student_mapping.id_first_language', $subjectId)
                                            ->orWhere('tbl_student_mapping.id_second_language', $subjectId)
                                            ->orWhere('tbl_student_mapping.id_third_language', $subjectId)
                                            ->orWhere('tbl_student_electives.id_elective', $subjectId)
                                            ->select('tbl_student.*', 'tbl_student_mapping.*')
                                            ->groupBy('tbl_student_mapping.id_student')->get();
            // dd(\DB::getQueryLog());
            return $studentDetails;
        }

        public function studentName($firstName, $secondName='', $thirdName=''){
            $output = $firstName;

            if($secondName != ''){
                $output .= ' '.$secondName;
            }
            if($thirdName !=''){
                $output .= ' '.$thirdName;
            }

            return $output;
        }

        public function checkFeeTypeUsedInStudent($idFeeType){
            return studentMapping::where('id_fee_type', $idFeeType)->first();
        }


        public function fetchStudentByStandardFeetype($standardId, $idFeeType, $allSessions){

            DB::enableQueryLog();
            
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $studentDetails = StudentMapping::join('tbl_student', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                                            ->where('tbl_student_mapping.id_standard', $standardId)   
                                            ->where('tbl_student_mapping.id_fee_type', $idFeeType)
                                            ->where('tbl_student_mapping.id_institute', $institutionId)
                                            ->where('tbl_student_mapping.id_academic_year', $academicYear)
                                            ->select('tbl_student.*', 'tbl_student_mapping.*')->get();
            // dd(\DB::getQueryLog());
            return $studentDetails;
        }        

    }
?>
