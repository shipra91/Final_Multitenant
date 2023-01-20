<?php
    namespace App\Repositories;
    use App\Models\MessageGroupMembers;
    use App\Interfaces\MessageGroupMembersRepositoryInterface;
    use DB;
    use Session;

    class MessageGroupMembersRepository implements MessageGroupMembersRepositoryInterface{
  
        public function all($groupId){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return MessageGroupMembers::where('id_institute', $institutionId)->where('id_academic', $academicId)->where('id_message_group', $groupId)->get();
        }

        public function store($data){
            return $messageGroupMembers = MessageGroupMembers::create($data);
        }

        public function fetch($id){            
            $messageGroupMembers = MessageGroupMembers::find($id);
            return $messageGroupMembers;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $institutionType = MessageGroupMembers::find($id)->delete();
        }

    }
