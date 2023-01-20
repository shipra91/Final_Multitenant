<?php 
    namespace App\Repositories;
    use App\Models\Holiday;
    use App\Interfaces\HolidayRepositoryInterface;

    class HolidayRepository implements HolidayRepositoryInterface{

        public function all(){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            
            return Holiday::where('id_institute', $institutionId)
              ->where('id_academic', $academicId)->orderBy('created_at', 'ASC')->get();           
        }

        public function store($data){
            return Holiday::create($data);
        }        

        public function fetch($id){
            return Holiday::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id){
            return Holiday::find($id)->delete();
        }

        public function allDeleted(){
            return Holiday::onlyTrashed()->get();
        }        

        public function restore($id){
            return Holiday::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return Holiday::onlyTrashed()->restore();
        }

        //FUNCTION TO CALENDER DATA
        public function getHolidayData($request){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $data = Holiday::whereDate('start_date', '>=', $request->start)
                        ->whereDate('end_date', '<=', $request->end)
                        ->where('id_institute', $institutionId)
                        ->where('id_academic', $academicId)
                        ->get();
            return $data;
        }
    }
?>