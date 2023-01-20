<?php
    namespace App\Repositories;
    use App\Models\ExamRoomStudentMapping;
    // use App\Models\RoomMaster;
    use App\Interfaces\ExamRoomStudentMappingRepositoryInterface;

    class ExamRoomStudentMappingRepository implements ExamRoomStudentMappingRepositoryInterface{

        public function all(){
            return ExamRoomStudentMapping::all();
        }

        public function store($data){
            return ExamRoomStudentMapping::create($data);
        }

        public function fetch($id){
            return ExamRoomStudentMapping::find($id);
        }
        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return ExamRoomStudentMapping::where('id_examination_room_setting', $id)->delete();
        }
    }

