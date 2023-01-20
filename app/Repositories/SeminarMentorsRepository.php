<?php
    namespace App\Repositories;
    use App\Models\SeminarMentors;
    use App\Interfaces\SeminarMentorsRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class SeminarMentorsRepository implements SeminarMentorsRepositoryInterface{

        public function all($idSeminar){

            return SeminarMentors::where('id_seminar', $idSeminar)->get();
        }

        public function store($data){
            return $seminarMentors = SeminarMentors::create($data);
        }

        public function fetch($id){
            return $seminarMentors = SeminarMentors::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($idSeminar){
            return $seminarMentors = SeminarMentors::where('id_seminar', $idSeminar)->delete();
        }

        public function seminarRecepientType($idSeminar){
            return SeminarMentors::where('id_seminar', $idSeminar)->groupBy('recipient_type')->get();
        }

        public function seminarRecepients($idSeminar, $recepientType){
            return SeminarMentors::where('id_seminar', $idSeminar)->where('recipient_type', $recepientType)->get();
        }
    }
