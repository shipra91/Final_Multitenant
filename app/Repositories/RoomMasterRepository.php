<?php
    namespace App\Repositories;
    use App\Models\RoomMaster;
    use App\Interfaces\RoomMasterRepositoryInterface;
    use Session;
    use DB;

    class RoomMasterRepository implements RoomMasterRepositoryInterface{

        public function all(){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            //\DB::enableQueryLog();
            $rooms= RoomMaster::where('id_institute', $institutionId)->where('id_academic_year', $academicId)->get();
            //dd(\DB::getQueryLog());
            return $rooms;
        }

        public function store($data){
            return RoomMaster::create($data);
        }

        public function fetch($id){
           return RoomMaster::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return RoomMaster::delete($id);
        }

        // public function fetchRoomMaster($idInstitutionStandard){
        //     return RoomMaster::where('id_standard', $idInstitutionStandard)->get();
        // }

        public function updateRoomMaster($data, $id){
            return RoomMaster::whereId($id)->update($data);
        }
    }
?>
