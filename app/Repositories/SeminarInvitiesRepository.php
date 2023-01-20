<?php
    namespace App\Repositories;
    use App\Models\SeminarInvities;
    use App\Interfaces\SeminarInvitiesRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class SeminarInvitiesRepository implements SeminarInvitiesRepositoryInterface{

        public function all($idSeminar){

            return SeminarInvities::where('id_seminar', $idSeminar)->get();
        }

        public function store($data){
            return $seminarInvities = SeminarInvities::create($data);
        }

        public function fetch($id){
            return $seminarInvities = SeminarInvities::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($idCategory){
            return $seminarInvities = SeminarInvities::where('id_seminar', $idCategory)->delete();
        }

        public function getRecipientType($idSeminar){

            return SeminarInvities::where('id_seminar', $idSeminar)->groupBy('recipient_type')->get();
        }

        public function allSeminarCategory($idSeminar, $recepientType){

            return SeminarInvities::where('id_seminar', $idSeminar)->where('recipient_type', $recepientType)->select('id_staff_category')->groupBy('id_staff_category')->get();
        }

        public function allSeminarSubCategory($idSeminar, $recepientType){

            return SeminarInvities::where('id_seminar', $idSeminar)->where('recipient_type', $recepientType)->select('id_staff_subcategory')->groupBy('id_staff_subcategory')->get();
        }

        public function allSeminarStandards($idSeminar, $recepientType){
            return SeminarInvities::where('id_seminar', $idSeminar)->where('recipient_type', $recepientType)->select('id_standard')->groupBy('id_standard')->get();
        }

        public function allSeminarSubjects($idSeminar, $recepientType){
            return SeminarInvities::where('id_seminar', $idSeminar)->where('recipient_type', $recepientType)->select('id_subject')->groupBy('id_subject')->get();
        }
    }
