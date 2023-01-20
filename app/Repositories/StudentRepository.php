<?php
    namespace App\Repositories;
    use App\Models\Student;
    use App\Interfaces\StudentRepositoryInterface;
    use Storage;
    use Session;
    use DB;

    class StudentRepository implements StudentRepositoryInterface {

        public function all($allSessions){
            
            $institutionId = $allSessions['institutionId'];          
            $organizationId = $allSessions['organizationId'];
            $academicYear = $allSessions['academicYear'];

            return Student::Select('tbl_student.*')
                            ->join('tbl_student_mapping', 'tbl_student_mapping.id_student', '=', 'tbl_student.id')
                            ->where("id_institute", $institutionId)
                            ->where("id_organization", $organizationId)
                            ->where("id_academic_year", $academicYear)
                            ->get();
        }

        public function store($data){
            return Student::create($data);
        }

        public function fetch($id){
            return Student::find($id);
        }

        public function getMaxStudentId(){
            $uid = Student::withTrashed()->max('egenius_uid');

            if($uid){
                $max = $uid + 1;
            }else{
                $max = '20001';
            }
            return $max;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return Student::find($id)->delete();
        }

        public function fetchStudents($term, $allSessions){

            $institutionId = $allSessions['institutionId'];          
            $organizationId = $allSessions['organizationId'];
            $academicYear = $allSessions['academicYear'];

            $students = Student::Select('tbl_student.*', 'tbl_student_mapping.id_standard')
                            ->join('tbl_student_mapping', 'tbl_student_mapping.id_student', '=', 'tbl_student.id')
                            ->where("id_institute", $institutionId)
                            ->where("id_organization", $organizationId)
                            ->where("id_academic_year", $academicYear)
                            ->where("name", 'LIKE','%'.$term.'%')
                            ->orWhere("egenius_uid", 'LIKE','%'.$term.'%')
                            ->orWhere("usn", 'LIKE','%'.$term.'%')
                            ->orWhere("father_mobile_number", 'LIKE','%'.$term.'%')
                            ->groupBy('tbl_student_mapping.id_student')->get();
            return $students;
        }

        public function getStudentByStandard($term, $details, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $idStandards = $details[1];

            $students = Student::Select('tbl_student.*', 'tbl_student_mapping.id_standard')
                            ->join('tbl_student_mapping', 'tbl_student_mapping.id_student', '=', 'tbl_student.id')
                            ->where('tbl_student_mapping.id_institute', $institutionId)
                            ->where('tbl_student_mapping.id_academic_year', $academicYear)
                            ->whereIn('id_standard', $idStandards)
                            ->where("name", 'LIKE','%'.$term.'%')
                            ->orWhere("egenius_uid", 'LIKE','%'.$term.'%')
                            ->orWhere("usn", 'LIKE','%'.$term.'%')
                            ->orWhere("father_mobile_number", 'LIKE','%'.$term.'%')
                            ->get();

            return $students;
        }

        public function getStudentBySubject($term, $details, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $idStandards = $details[1];
            $subjectId = $details[2];

            $students = Student::Select('tbl_student.*', 'tbl_student_mapping.id_standard')
                            ->join('tbl_student_mapping', 'tbl_student_mapping.id_student', '=', 'tbl_student.id')
                            ->leftJoin('tbl_student_electives', 'tbl_student.id', '=', 'tbl_student_electives.id_student')
                            ->where('tbl_student_mapping.id_institute', $institutionId)
                            ->where('tbl_student_mapping.id_academic_year', $academicYear)
                            ->where(function($q) use($subjectId){
                                $q->where('id_first_language', $subjectId)
                                ->orWhere('id_second_language', $subjectId)
                                ->orWhere('id_third_language', $subjectId)
                                ->orWhere('tbl_student_electives.id_elective', $subjectId);
                            })
                            ->whereIn('tbl_student_mapping.id_standard', $idStandards)
                            ->where(function($query) use($term){
                                $query->where("name", 'LIKE','%'.$term.'%')
                                ->orWhere("egenius_uid", 'LIKE','%'.$term.'%')
                                ->orWhere("usn", 'LIKE','%'.$term.'%')
                                ->orWhere("father_mobile_number", 'LIKE','%'.$term.'%');
                            })
                            ->groupBy('tbl_student_mapping.id_student')
                            ->get();
            return $students;
        }

        public function fetchStudentByStandard($details, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $idStandards = $details[1];

            $students = Student::Select('tbl_student.*', 'tbl_student_mapping.id_standard')
                        ->join('tbl_student_mapping', 'tbl_student_mapping.id_student', '=', 'tbl_student.id')
                        ->where('tbl_student_mapping.id_institute', $institutionId)
                        ->where('tbl_student_mapping.id_academic_year', $academicYear)
                        ->whereIn('id_standard', $idStandards)
                        ->get();

            return $students;
        }

        public function fetchStudentBySubject($details, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $idStandards = $details[1];
            $subjectId = $details[2];

            $students = Student::Select('tbl_student.*', 'tbl_student_mapping.id_standard')
                        ->join('tbl_student_mapping', 'tbl_student_mapping.id_student', '=', 'tbl_student.id')
                        ->leftJoin('tbl_student_electives', 'tbl_student.id', '=', 'tbl_student_electives.id_student')
                        ->where('tbl_student_mapping.id_institute', $institutionId)
                        ->where('tbl_student_mapping.id_academic_year', $academicYear)
                        ->where('id_first_language', $subjectId)
                        ->orWhere('id_second_language', $subjectId)
                        ->orWhere('id_third_language', $subjectId)
                        ->orWhere('tbl_student_electives.id_elective', $subjectId)
                        ->whereIn('id_standard', $idStandards)->get();
            return $students;
        }

        public function getStudent($request){

            $institutionId = $request->institutionId;
            // $academicYear = $request->academicYear;
            $mobileNumber = $request->mobile;

            $studentData = Student::Select('tbl_student.*', 'tbl_student_mapping.id_standard')
                        ->join('tbl_student_mapping', 'tbl_student_mapping.id_student', '=', 'tbl_student.id')
                        ->where("id_institute", $institutionId)
                        // ->where("id_academic_year", $academicYear)
                        ->where("father_mobile_number", $mobileNumber)
                        ->orWhere("mother_mobile_number", $mobileNumber)
                        ->orderBy('tbl_student_mapping.created_at', 'Desc')
                        ->first();

            return $studentData;
        }

        public function fetchStudentCount($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $students = Student::select(\DB::raw('COUNT(tbl_student.id) as studentCount'))
                        ->join('tbl_student_mapping', 'tbl_student_mapping.id_student', '=', 'tbl_student.id')
                        ->where('tbl_student_mapping.id_institute', $institutionId)
                        ->where('tbl_student_mapping.id_academic_year', $academicYear)
                        ->first();
            return $students;
        }

        public function userExist($mobile, $institutionId){
            $studentData = Student::join('tbl_student_mapping', 'tbl_student_mapping.id_student', '=', 'tbl_student.id')
                        ->where('father_mobile_number', $mobile)
                        ->orWhere('mother_mobile_number', $mobile)
                        ->select('tbl_student.*', 'tbl_student_mapping.*')
                        ->where(function($query1) use ($institutionId){
                            $query1->where('id_organization', $institutionId)
                                    ->orWhere('id_institute', $institutionId);
                        })
                        ->first();
            return $studentData;
        }

        public function allStudentExist($mobile, $institutionId){

            $studentData = Student::join('tbl_student_mapping', 'tbl_student_mapping.id_student', '=', 'tbl_student.id')
                        ->where('tbl_student_mapping.id_institute', $institutionId)
                        ->where(function($query) use ($mobile){
                            $query->where('father_mobile_number', $mobile)
                            ->orWhere('mother_mobile_number', $mobile);
                        })
                        ->select('tbl_student.*', 'tbl_student_mapping.*')
                        ->get();
            return $studentData;
        }

        public function fetchStudentOnBatch($batchStudentId, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            //DB::enableQueryLog();
            $students = Student::Select('tbl_student.*')
                        ->join('tbl_student_mapping', 'tbl_student_mapping.id_student', '=', 'tbl_student.id')
                        ->join('tbl_batch_student', 'tbl_student_mapping.id_student', '=', 'tbl_batch_student.id_student')
                        ->where('tbl_student_mapping.id_institute', $institutionId)
                        ->where('tbl_student_mapping.id_academic_year', $academicYear)
                        ->where('tbl_batch_student.id_batch_detail', $batchStudentId)->get();
            // dd(\DB::getQueryLog());
            return $students;
        }

        public function allStudentUser($mobile, $institutionId){

            $studentData = Student::join('tbl_student_mapping', 'tbl_student_mapping.id_student', '=', 'tbl_student.id')
                        // ->where('tbl_student_mapping.id_institute', $institutionId)
                        ->where(function($query) use ($mobile){
                            $query->where('father_mobile_number', $mobile)
                            ->orWhere('mother_mobile_number', $mobile);
                        })
                        ->where(function($query1) use ($institutionId){
                            $query1->where('id_organization', $institutionId)
                                ->orWhere('id_institute', $institutionId);
                        })
                        ->select('tbl_student.*', 'tbl_student_mapping.*')
                        ->get();
            return $studentData;
        }

        public function userExistForInstitution($mobile, $institutionId){
            $studentData = Student::join('tbl_student_mapping', 'tbl_student_mapping.id_student', '=', 'tbl_student.id')
                        ->where(function($query) use ($mobile){
                            $query->where('father_mobile_number', $mobile)
                                ->orWhere('mother_mobile_number', $mobile);
                        })
                        ->where(function($query1) use ($institutionId){
                            $query1->where('tbl_student_mapping.id_organization', $institutionId)
                                ->orWhere('tbl_student_mapping.id_institute', $institutionId);
                        })
                        ->select('tbl_student.*', 'tbl_student_mapping.*')
                        ->first();
            return $studentData;
        }

        public function checkIfPreadmissionDataExists($fName, $mName, $lName, $mobileNumber){
            $data = Student::where('name', $fName)
                                ->where('middle_name', $mName)
                                ->where('last_name', $lName)
                                ->where('father_mobile_number', $mobileNumber)
                                ->first();
            return $data;
        }
    }
?>
