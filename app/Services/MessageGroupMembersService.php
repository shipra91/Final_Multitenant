<?php 
    namespace App\Services;
    use App\Models\MessageGroupMembers;
    use App\Repositories\MessageGroupMembersRepository;
    use App\Repositories\MessageGroupNameRepository;
    use Carbon\Carbon;
    use Session;

    class MessageGroupMembersService {

<<<<<<< HEAD
        public function all($groupId) {
            $messageGroupMemberDetails = array();
            $messageGroupMembersRepository = new MessageGroupMembersRepository();
            $messageGroupNameRepository = new MessageGroupNameRepository();
            $messageGroupMemberDetails = $messageGroupMembersRepository->all($groupId);
=======
        public function all($groupId, $allSessions) {
            $messageGroupMemberDetails = array();
            $messageGroupMembersRepository = new MessageGroupMembersRepository();
            $messageGroupNameRepository = new MessageGroupNameRepository();
            $messageGroupMemberDetails = $messageGroupMembersRepository->all($groupId, $allSessions);
>>>>>>> main

            if(count($messageGroupMemberDetails)>0){
                $messageGroupNameDetails = $messageGroupNameRepository->fetch($groupId);
                $messageGroupMemberDetails[0]['messageGroupName'] = $messageGroupNameDetails->group_name;
            }

            return $messageGroupMemberDetails;
        }

        public function find($id){
            $messageGroupMembersRepository = new MessageGroupMembersRepository();
            return $messageGroupMembersRepository->fetch($id);
        } 
        
        public function add($data) {
            
<<<<<<< HEAD
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
=======
            $institutionId = $data->id_institute;
            $academicId = $data->id_academic;
>>>>>>> main

            $messageGroupMembersRepository = new MessageGroupMembersRepository();
            $groupNameId = $data->group_name;
            if($data->student_name != ''){
                $memberName = $data->student_name;
            }else{
                $memberName = $data->student_details;
            }
            
            $phoneNumber = $data->phone_number;
            
            $check = MessageGroupMembers::where('id_institute', $institutionId)
                                        ->where('id_academic', $academicId)
                                        ->where('id_message_group', $groupNameId)
                                        ->where('phone_number', $phoneNumber)
                                        ->first();
            if(!$check){

                $details = array(
                    'id_institute'=>$institutionId,
                    'id_academic'=>$academicId,
                    'id_message_group'=>$groupNameId,
                    'name' => $memberName,
                    'phone_number'=>$phoneNumber,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $store = $messageGroupMembersRepository->store($details);
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

        public function addExcelData($data) {
            
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $messageGroupMembersRepository = new MessageGroupMembersRepository();
            $groupNameId = $data->group_name;
            if($data->file){
                $filename = explode(".", $data->file['name']);
              dd($filename);  
            }


            dd($data);
            $name = $data->student_name;
            $phoneNumber = $data->phone_number;
            
            $check = MessageGroupMembers::where('id_institute', $institutionId)->where('id_academic', $academicId)->where('id_message_group', $groupNameId)->where('phone_number', $phoneNumber)->first();
            if(!$check){

                $details = array(
                    'id_institute'=>$institutionId,
                    'id_academic'=>$academicId,
                    'id_message_group'=>$groupNameId,
                    'name'=>$name,
                    'phone_number'=>$phoneNumber,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $store = $messageGroupMembersRepository->store($details);

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

            $messageGroupMembersRepository = new MessageGroupMembersRepository();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $groupDetails = $messageGroupMembersRepository->fetch($id);

            $check = MessageGroupMembers::where('id_institute', $institutionId)->where('id_academic', $academicId)->where('group_name', $data->group_name)->where('id', '!=', $id)->first();
            if(!$check){

                $groupDetails->group_name = $data->group_name;
                $groupDetails->modified_by = Session::get('userId');
                $groupDetails->updated_at =  Carbon::now();
                $update = $messageGroupMembersRepository->update($groupDetails);

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

            $messageGroupMembersRepository = new MessageGroupMembersRepository();

            $messageGroupMembers = $messageGroupMembersRepository->delete($id);

            if($messageGroupMembers){
                $signal = 'success';
                $msg = 'Group Member deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }


        public function getDeletedRecords(){

            $messageGroupMembersRepository = new MessageGroupMembersRepository();
            $messageGroupMembersData = $messageGroupMembersRepository->allDeleted();
            return $messageGroupMembersData;
        }

        public function restore($id){
            $messageGroupMembersRepository = new MessageGroupMembersRepository();
            $messageGroupMembers = $messageGroupMembersRepository->restore($id);
            if($messageGroupMembers){
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