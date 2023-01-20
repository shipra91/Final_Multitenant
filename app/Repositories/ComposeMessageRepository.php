<?php 
    namespace App\Repositories;
    use App\Models\ComposeMessage;
    use App\Interfaces\ComposeMessageRepositoryInterface;

    class ComposeMessageRepository implements ComposeMessageRepositoryInterface{

        public function all(){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return ComposeMessage::where('id_institute', $institutionId)
            ->where('id_academic', $academicId)->get();            
        }

        public function store($data){
            return ComposeMessage::create($data);
        }        

        public function fetch($id){
            return ComposeMessage::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id){
            return ComposeMessage::find($id)->delete();
        }
    }
?>