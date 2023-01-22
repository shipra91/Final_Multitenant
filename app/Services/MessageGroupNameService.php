<?php 
    namespace App\Services;
    use App\Models\MessageGroupName;
    use App\Repositories\MessageGroupNameRepository;
    use App\Services\MessageGroupNameService;
    use Carbon\Carbon;
    use Session;

    class MessageGroupNameService {

        public function all($allSessions) {

            $messageGroupNameData = array();
            $messageGroupNameRepository = new MessageGroupNameRepository();
            $messageGroupMembersService = new MessageGroupMembersService();

            $messageGroupNames= $messageGroupNameRepository->all($allSessions);
            foreach($messageGroupNames as $index => $data) {
                $groupMemberDetails = $messageGroupMembersService->all($data->id, $allSessions);
                $messageGroupNameData[$index] = $data;
                $messageGroupNameData[$index]['count'] = count($groupMemberDetails);
            }
            return $messageGroupNameData;
        }

        public function find($id){
            $messageGroupNameRepository = new MessageGroupNameRepository();
            return $messageGroupNameRepository->fetch($id);
        } 
        
        public function add($data) {
            
            $institutionId = $data->id_institute;
            $academicId = $data->id_academic;

            $messageGroupNameRepository = new MessageGroupNameRepository();
            $groupName = $data->group_name;
            
            $check = MessageGroupName::where('id_institute', $institutionId)->where('id_academic', $academicId)->where('group_name', $groupName)->first();
            if(!$check){

                $details = array(
                    'id_institute'=>$institutionId,
                    'id_academic'=>$academicId,
                    'group_name'=>$groupName,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $store = $messageGroupNameRepository->store($details);
                if($store){
                    $signal = 'success';
                    $msg = 'Data inserted successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error inserting data!';
                }

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;
        }

        public function update($data, $id) {

            $messageGroupNameRepository = new MessageGroupNameRepository();
            
            $institutionId = $data->id_institute;
            $academicId = $data->id_academic;

            $groupDetails = $messageGroupNameRepository->fetch($id);

            $check = MessageGroupName::where('id_institute', $institutionId)->where('id_academic', $academicId)->where('group_name', $data->group_name)->where('id', '!=', $id)->first();
            if(!$check){

                $groupDetails->group_name = $data->group_name;
                $groupDetails->modified_by = Session::get('userId');
                $groupDetails->updated_at =  Carbon::now();
                $update = $messageGroupNameRepository->update($groupDetails);

                if($update){
                    $signal = 'success';
                    $msg = 'Data Updated Successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error in updating!';
                }
            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;
        }

        public function delete($id){

            $messageGroupNameRepository = new MessageGroupNameRepository();

            $messageGroupName = $messageGroupNameRepository->delete($id);

            if($messageGroupName){
                $signal = 'success';
                $msg = 'Group Name deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }


        public function getDeletedRecords($allSessions){

            $messageGroupNameRepository = new MessageGroupNameRepository();
            $messageGroupNameData = $messageGroupNameRepository->allDeleted($allSessions);
            return $messageGroupNameData;
        }

        public function restore($id){
            $messageGroupNameRepository = new MessageGroupNameRepository();
            $messageGroupName = $messageGroupNameRepository->restore($id);
            if($messageGroupName){
                    $signal = 'success';
                    $msg = 'Data restored successfully!';
            }else{
                    $signal = 'failure';
                    $msg = 'Data deletion is failed!';
            }
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;
        }  
    }
?>