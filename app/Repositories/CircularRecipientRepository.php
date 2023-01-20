<?php
    namespace App\Repositories;
    use App\Models\CircularRecipient;
    use App\Interfaces\CircularRecipientRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class CircularRecipientRepository implements CircularRecipientRepositoryInterface{

        public function all(){
            return CircularRecipient::all();
        }

        public function store($data){
            return $circularRecipient = CircularRecipient::create($data);
        }

        public function fetch($id){
            return $circularRecipient = CircularRecipient::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($idCircular){
            return $circularRecipient = CircularRecipient::where('id_circular', $idCircular)->delete();
        }

        public function circularRecepientType($idCircular){
            return CircularRecipient::where('id_circular', $idCircular)->groupBy('recipient_type')->get();
        }

        public function circularRecepients($idCircular, $recepientType){
            return CircularRecipient::where('id_circular', $idCircular)->where('recipient_type', $recepientType)->get();
        }
    }
