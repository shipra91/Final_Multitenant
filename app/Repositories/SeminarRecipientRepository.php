<?php
    namespace App\Repositories;
    use App\Models\SeminarRecipient;
    use App\Interfaces\SeminarRecipientRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class SeminarRecipientRepository implements SeminarRecipientRepositoryInterface{

        public function all(){
            return SeminarRecipient::all();
        }

        public function store($data){
            return $seminarRecipient = SeminarRecipient::create($data);
        }

        public function fetch($idSeminar){
            return SeminarRecipient::where('id_seminar', $idSeminar)->get();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($idSeminar){
            return $seminarRecipient = SeminarRecipient::where('id_seminar', $idSeminar)->delete();
        }

        public function seminarRecipientType($idSeminar){
            return SeminarRecipient::where('id_seminar', $idSeminar)->groupBy('recipient_type')->get();
        }

        public function seminarRecipients($idSeminar, $recepientType){
            return SeminarRecipient::where('id_seminar', $idSeminar)->where('recipient_type', $recepientType)->get();
        }
    }
