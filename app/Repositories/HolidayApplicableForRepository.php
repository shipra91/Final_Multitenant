<?php 
    namespace App\Repositories;
    use App\Models\HolidayApplicableFor;
    use App\Interfaces\HolidayApplicableForRepositoryInterface;

    class HolidayApplicableForRepository implements HolidayApplicableForRepositoryInterface{

        public function all(){
            return HolidayApplicableFor::all();            
        }

        public function store($data){
            return HolidayApplicableFor::create($data);
        }        

        public function fetch($id){
            return HolidayApplicableFor::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($holidayId){
            return HolidayApplicableFor::where('id_holiday', $holidayId)->delete();
        }

        public function holidayRecepientType($holidayId){
            return HolidayApplicableFor::where('id_holiday', $holidayId)->groupBy('applicable_for')->get();
        }

        public function allHolidayCategory($idHoliday, $recepientType){

            return HolidayApplicableFor::where('id_holiday', $idHoliday)->where('applicable_for', $recepientType)->select('id_staff_category')->groupBy('id_staff_category')->get();
        }

        public function allHolidaySubCategory($idHoliday, $recepientType){

            return HolidayApplicableFor::where('id_holiday', $idHoliday)->where('applicable_for', $recepientType)->select('id_staff_subcategory')->groupBy('id_staff_subcategory')->get();
        }

        public function allHolidayStandards($idHoliday, $recepientType){
            return HolidayApplicableFor::where('id_holiday', $idHoliday)->where('applicable_for', $recepientType)->select('id_standard')->groupBy('id_standard')->get();
        }
    }
?>