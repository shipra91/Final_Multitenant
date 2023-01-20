<?php 
namespace App\Services;
use App\Models\MessageSenderEntity;
use App\Repositories\MessageSenderEntityRepository;
use Carbon\Carbon;
use Session;

class MessageSenderEntityService {

    public function add($senderEntityData) {
        $storeCount = 0;
        $messageSenderEntityRepository = new MessageSenderEntityRepository();
        $senderIdData = $senderEntityData->sender_id;    
        if(count($senderIdData) > 0) {
            foreach ($senderIdData as $key => $senderId) {
                $entityId = $senderEntityData->entity_id[$key];
                $check = MessageSenderEntity::where('sender_id', $senderId)->first();
                if(!$check){
                    $details = array(
                        'sender_id'=>$senderId,
                        'entity_id'=>$entityId,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                    );
                    $store = $messageSenderEntityRepository->store($details);
                  
                    if($store) {
                        $storeCount = $storeCount + 1;
                    }
                }
            }
        }

        if($storeCount > 0) {
                $signal = 'success';
                $msg = 'Data Inserted successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error in inserting data!';
            } 
        
        $output = array(
            'signal'=>$signal,
            'message'=>$msg
        );

        return $output;
    }    

    public function getDetails() {
        $messageSenderEntityRepository = new MessageSenderEntityRepository();
        return $messageSenderEntityRepository->all();
    }

    public function find($id) {
        $messageSenderEntityRepository = new MessageSenderEntityRepository();
        return $messageSenderEntityRepository->fetch($id);
    }

    public function update($senderEntityData, $id) {
        $messageSenderEntityRepository = new MessageSenderEntityRepository();

        $check = MessageSenderEntity::where('sender_id', $senderEntityData->sender_id)->where('id', '!=', $id)->first();
        if(!$check){
            $senderEntityDetails = $messageSenderEntityRepository->fetch($id);

            $senderEntityDetails->sender_id = $senderEntityData->sender_id;
            $senderEntityDetails->entity_id = $senderEntityData->entity_id;
            $senderEntityDetails->modified_by = Session::get('userId');
            $senderEntityDetails->updated_at = Carbon::now();

            $update = $messageSenderEntityRepository->update($senderEntityDetails);

            if($update) {
                $signal = 'success';
                $msg = 'Data Updated successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error in Updating data!';
            } 
        }else{
            $signal = 'exists';
            $msg = 'This data already exist!';
        } 
    
        $output = array(
            'signal'=>$signal,
            'message'=>$msg
        );

        return $output;
    }

    // Delete MessageSenderEntity
    public function delete($id){
        $messageSenderEntityRepository = new MessageSenderEntityRepository();
        
        $messageSenderEntity = $messageSenderEntityRepository->delete($id);

        if($messageSenderEntity){
            $signal = 'success';
            $msg = 'Data deleted successfully!';
        }

        $output = array(
            'signal'=>$signal,
            'message'=>$msg
        );

        return $output;
    }

    public function getDeletedRecords(){

        $messageSenderEntityRepository = new MessageSenderEntityRepository();
        $messageSenderEntityDetail = array();
        $messageSenderEntityData = $messageSenderEntityRepository->allDeleted();
        return $messageSenderEntityData;
    }

    public function restore($id){

        $messageSenderEntityRepository = new MessageSenderEntityRepository();
        $messageSenderEntity = $messageSenderEntityRepository->restore($id);
        if($messageSenderEntity){
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

    public function fetchDetails($senderId) {
        $messageSenderEntityRepository = new MessageSenderEntityRepository();
        return $messageSenderEntityRepository->fetchDetails($senderId);
    }
}


?>