<?php 
namespace App\Services;
use App\Models\MessageCredit;
use App\Repositories\MessageCreditDetailsRepository;
use App\Repositories\MessageCreditRepository;
use App\Services\InstituteService;
use Session;
use Carbon\Carbon;

class MessageCreditDetailsService {

    public function getAll(){
        $allMessageCreditDetails = array();
        $messageCreditRepository = new MessageCreditRepository();
        $instituteService = new InstituteService();
        $messageCreditDetails = $messageCreditRepository->all();
        //dd($messageCreditDetails);
        if(count($messageCreditDetails) > 0){
            foreach ($messageCreditDetails as $key => $details) {
                $institutionId = $details->id_institute;
                $institutionDetails = $instituteService->find($institutionId);
                $allMessageCreditDetails[$key]['id'] = $details->id;
                $allMessageCreditDetails[$key]['institution_id'] = $institutionId;
                $allMessageCreditDetails[$key]['institution_name'] = $institutionDetails->name;
                $allMessageCreditDetails[$key]['available_credits'] = $details->total_credit_available;
            }
        }
        return $allMessageCreditDetails;
    }

    public function getInstitutionCreditDetails($institutionId){
        // dd($institutionId);
        $InstitutionMessageCreditDetails = array();
        $messageCreditDetailsRepository = new MessageCreditDetailsRepository();
        $messageCreditDetails = $messageCreditDetailsRepository->all($institutionId);
        // dd($messageCreditDetails);

        foreach ($messageCreditDetails as $key => $details) { 
           
            $InstitutionMessageCreditDetails[$key] = $details; 
          
            if($details->credit_type == 'AS_PER_PO')
            {
                $InstitutionMessageCreditDetails[$key]['amount_received_date'] = '-';  
                $InstitutionMessageCreditDetails[$key]['amount'] = '-';  
                $InstitutionMessageCreditDetails[$key]['narration'] = '-';
                $InstitutionMessageCreditDetails[$key]['transaction_id'] = '-';
            }
            else{
                $receivedOn = Carbon::createFromFormat('Y-m-d', $details->amount_received_on)->format('d-m-Y');
                $InstitutionMessageCreditDetails[$key]['amount_received_date'] = $receivedOn; 
            }
        }

        // dd($InstitutionMessageCreditDetails);
        return $InstitutionMessageCreditDetails;
    }

    public function getData($data) {
        $institutionId = $data->get('institution');
        if(!empty($institutionId)){
            $messageCreditDetails['institution'] = $institutionId;
        }else {
            $messageCreditDetails['institution'] = '';
        }
        
        return $messageCreditDetails;
    }

    public function add($creditData) {
        
        $messageCreditRepository = new MessageCreditRepository();
        $messageCreditDetailsRepository = new MessageCreditDetailsRepository();
        $receivedOn = '';
        $amount = '';
        $transactionId = '';
        $narration = '';
        $totalCreditAvailable = 0;
        $institutionId = $creditData->institutionId;
        $numberOfCredits = $creditData->number_of_credits;
        $creditType = $creditData->credit_type;
       
        if($creditType == 'PAID') {
            $receivedOn = Carbon::createFromFormat('d/m/Y', $creditData->received_on)->format('Y-m-d');
            $amount = $creditData->amount;
            $transactionId = $creditData->transaction_id;
            $narration = $creditData->narration;
        }

        $messageCreditDetails = MessageCredit::where('id_institute', $institutionId)->first();
           
        if(!$messageCreditDetails){
            $data = array(
                'id_institute'=>$institutionId,
                'total_credit_available'=>$numberOfCredits,
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );
            $updateData = $messageCreditRepository->store($data);
            $messageCreditId = $updateData->id;   
        }
        else{
            $messageCreditId = $messageCreditDetails->id;  
            $totalCreditAvailable = $messageCreditDetails->total_credit_available;   
            $totalCreditAvailable = (int) $totalCreditAvailable + (int) $numberOfCredits;
            $messageCreditDetails->total_credit_available = $totalCreditAvailable;
            $messageCreditDetails->modified_by =  Session::get('userId');
            $messageCreditDetails->updated_at = Carbon::now();
            $updateData = $messageCreditRepository->update($messageCreditDetails);

        }

        if($updateData){
            $detailsData = array(
                'id_message_credit'=>$messageCreditId,
                'credit_numbers'=>$numberOfCredits,
                'credit_type'=>$creditType,
                'amount_received_on'=>$receivedOn,
                'amount'=>$amount,
                'narration'=>$narration,
                'transaction_id'=>$transactionId,
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );
            $store = $messageCreditDetailsRepository->store($detailsData);
        }

        if($store){
            $signal = 'success';
            $msg = 'Data inserted successfully!';

        }else{
            $signal = 'failure';
            $msg = 'Error inserting data!';
        } 

        $output = array(
            'signal'=>$signal,
            'message'=>$msg
        );
        return $output;
    }
}
?>