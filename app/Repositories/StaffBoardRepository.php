<?php
    namespace App\Repositories;
    use App\Models\StaffBoardSelection;
    use App\Interfaces\StaffBoardRepositoryInterface;
    use DB;

    class StaffBoardRepository implements StaffBoardRepositoryInterface{

        // public function all(){
        //     return StaffBoardSelection::all();
        // }

        public function all($staffId){
            //DB::enableQueryLog();
            return $allBoards = StaffBoardSelection::where('id_staff', $staffId)->get();
            // dd(DB::getQueryLog());
        }

        public function store($data){
            return $staffBoardSelection = StaffBoardSelection::create($data);
        }

        public function fetch($id){
            return $staffBoardSelection = StaffBoardSelection::find($id);
        }

        public function update($data, $id){
            return StaffBoardSelection::whereId($id)->update($data);
        }

        public function delete($id){
            return $staffBoardSelection = StaffBoardSelection::find($id)->delete();
        }
    }
