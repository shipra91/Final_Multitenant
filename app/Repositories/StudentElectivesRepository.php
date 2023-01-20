<?php
    namespace App\Repositories;
    use App\Models\StudentElectives;
    use App\Interfaces\StudentElectivesRepositoryInterface;
    use DB;

    class StudentElectivesRepository implements StudentElectivesRepositoryInterface{

        public function all(){
            return StudentElectives::all();
        }

        public function store($data){
            $studentElectives = StudentElectives::create($data);
            return $studentElectives;
        }

        public function fetch($id){
            $studentElectives = StudentElectives::where($id);
            return $studentElectives;
        }

        public function fetchStudentSubjects($idStudent, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $studentElectives = StudentElectives::where('id_institute', $institutionId)
            ->where('id_academic_year', $academicYear)
            ->where('id_student', $idStudent)
            ->get();
            return $studentElectives;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($idStudent){           

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $studentElectives = StudentElectives::where('id_institute', $institutionId)
                                                        ->where('id_academic_year', $academicYear)
                                                        ->where('id_student', $idStudent)
                                                        ->delete();
            return $studentElectives;
        }
    }
