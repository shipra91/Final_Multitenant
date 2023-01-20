<?php
    namespace App\Repositories;
    use App\Models\ChallanRejectionReason;
    use App\Interfaces\ChallanRejectionReasonRepositoryInterface;
    use Session;

    class ChallanRejectionReasonRepository implements ChallanRejectionReasonRepositoryInterface{

        public function all(){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            return ChallanRejectionReason::where('id_institute', $institutionId)->orderBy('created_at', 'ASC')->get();
        }

        public function store($data){
            return $challanRejectionReason = ChallanRejectionReason::create($data);
        }

        public function fetch($id){
            return $challanRejectionReason = ChallanRejectionReason::find($id);
        } 

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $challanRejectionReason = ChallanRejectionReason::find($id)->delete();
        }
    }