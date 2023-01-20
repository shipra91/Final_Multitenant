<?php
    namespace App\Repositories;
    use App\Models\StaffScheduleMapping;
    use App\Interfaces\StaffScheduleMappingRepositoryInterface;

    class StaffScheduleMappingRepository implements StaffScheduleMappingRepositoryInterface{

        // public function all(){
        //     return StaffScheduleMapping::all();
        // }

        public function all($staffId, $day){
            //DB::enableQueryLog();
            return $staffScheduleMapping = StaffScheduleMapping::where('id_staff', $staffId)->where('day', $day)->orderBy('day')->get();
            // dd(DB::getQueryLog());
        }

        public function store($data){
            return $staffScheduleMapping = StaffScheduleMapping::create($data);
        }

        public function fetch($id){
            return $staffScheduleMapping = StaffScheduleMapping::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $staffScheduleMapping = StaffScheduleMapping::find($id)->delete();
        }
    }
