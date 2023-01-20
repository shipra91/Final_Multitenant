<?php
    namespace App\Repositories;
    use App\Models\MessageGroupName;
    use App\Interfaces\MessageGroupNameRepositoryInterface;
    use DB;
    use Session;

    class MessageGroupNameRepository implements MessageGroupNameRepositoryInterface{
  
        public function all(){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return MessageGroupName::where('id_institute', $institutionId)->where('id_academic', $academicId)->get();
        }

        public function store($data){
            return $messageGroupName = MessageGroupName::create($data);
        }

        public function fetch($id){            
            $messageGroupName = MessageGroupName::find($id);
            return $messageGroupName;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $institutionType = MessageGroupName::find($id)->delete();
        }

        public function allDeleted(){
            return MessageGroupName::onlyTrashed()->get();
        }        

        public function restore($id){
            return MessageGroupName::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return MessageGroupName::onlyTrashed()->restore();
        }

        public function getGroupNameId($groupName){
            return MessageGroupName::where('group_name', $groupName)->first();
        }

    }
?>
