<?php
    namespace App\Repositories;
    use App\Models\CircularApplicableTo;
    use App\Interfaces\CircularApplicableToRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class CircularApplicableToRepository implements CircularApplicableToRepositoryInterface{

        public function all($idCircular){

            return CircularApplicableTo::where('id_circular', $idCircular)->get();
        }

        public function store($data){
            return $circularApplicableTo = CircularApplicableTo::create($data);
        }

        public function fetch($id){
            return $circularApplicableTo = CircularApplicableTo::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($idCategory){
            return $circularApplicableTo = CircularApplicableTo::where('id_circular', $idCategory)->delete();
        }

        public function allCircularCategory($idCircular, $recepientType){

            return CircularApplicableTo::where('id_circular', $idCircular)->where('recipient_type', $recepientType)->select('id_staff_category')->groupBy('id_staff_category')->get();
        }

        public function allCircularSubCategory($idCircular, $recepientType){

            return CircularApplicableTo::where('id_circular', $idCircular)->where('recipient_type', $recepientType)->select('id_staff_subcategory')->groupBy('id_staff_subcategory')->get();
        }

        public function allCircularStandards($idCircular, $recepientType){
            return CircularApplicableTo::where('id_circular', $idCircular)->where('recipient_type', $recepientType)->select('id_standard')->groupBy('id_standard')->get();
        }

        public function allCircularSubjects($idCircular, $recepientType){
            return CircularApplicableTo::where('id_circular', $idCircular)->where('recipient_type', $recepientType)->select('id_subject')->groupBy('id_subject')->get();
        }
    }
