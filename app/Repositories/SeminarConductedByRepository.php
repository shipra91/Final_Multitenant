<?php
    namespace App\Repositories;
    use App\Models\SeminarConductedBy;
    use App\Interfaces\SeminarConductedByRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class SeminarConductedByRepository implements SeminarConductedByRepositoryInterface{

        public function all(){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $idStudent = 'd51eed06-0cec-4b39-9c6b-83ed7cd436b6';

            return SeminarConductedBy::join('tbl_seminar', 'tbl_seminar.id','=', 'tbl_seminar_conducted_by.id_seminar')
                                    ->where('id_institute', $institutionId)
                                    ->where('id_academic', $academicId)
                                    ->where('conducted_by', $idStudent)
                                    ->select('tbl_seminar.*','tbl_seminar_conducted_by.*')
                                    ->get();
        }

        public function store($data){
            return $seminarConductedBy = SeminarConductedBy::create($data);
        }

        public function fetch($idSeminar){
            return SeminarConductedBy::where('id_seminar', $idSeminar)->get();
        }

        public function fetchSeminar($id){
            return SeminarConductedBy::find($id);
        }

        public function fetchStudentSeminar($data){
            $idSeminar = $data['seminarId'];
            $idStudent = $data['studentId'];
            return SeminarConductedBy::join('tbl_seminar', 'tbl_seminar.id','=', 'tbl_seminar_conducted_by.id_seminar')
                                    ->where('id_seminar', $idSeminar)
                                    ->where('conducted_by', $idStudent)
                                    ->select('tbl_seminar.*','tbl_seminar_conducted_by.*')
                                    ->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($idSeminar){
            return $seminarConductedBy = SeminarConductedBy::where('id_seminar', $idSeminar)->delete();
        }
    }
