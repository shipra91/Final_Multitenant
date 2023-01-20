<?php
    namespace App\Repositories;
    use App\Models\InstitutionCourseMaster;
    use App\Interfaces\InstitutionCourseMasterRepositoryInterface;
    use DB;

    class InstitutionCourseMasterRepository implements InstitutionCourseMasterRepositoryInterface{

        public function all(){
            return InstitutionCourseMaster::select('board_university')->groupBy('board_university')->get();
        }

        public function fetchInstitutionCourseMaster($idInstitution){
            return InstitutionCourseMaster::where('id_institute', $idInstitution)
            ->groupBy('board_university')
            ->get();
        }

        public function store($data){
            return InstitutionCourseMaster::create($data);
        }

        public function fetch($id){
            return InstitutionCourseMaster::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return InstitutionCourseMaster::find($id)->delete();
        }

        public function checkCourseMasterExistence($idBoard, $idInstituteType, $idCourse, $idStream, $idCombination){
            return InstitutionCourseMaster::where('board_university', $idBoard)->where('institution_type', $idInstituteType)->where('course', $idCourse)->where('stream', $idStream)->where('combination', $idCombination)->first();
        }
    }

