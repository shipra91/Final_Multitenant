<?php
    namespace App\Services;
    use App\Models\InstitutionBankDetails;
    use App\Services\InstitutionBankDetailsService;
    use App\Repositories\InstitutionBankDetailsRepository;
    use App\Repositories\FeeChallanSettingRepository;
    use Carbon\Carbon;
    use Session;

    class InstitutionBankDetailsService {

        // Get all institutionBankDetails
        public function getAll(){

            $institutionBankDetailsRepository = new InstitutionBankDetailsRepository();
            $feeChallanSettingRepository = new FeeChallanSettingRepository();

            $institutionBankDetails = array();
            $institutionBankData = $institutionBankDetailsRepository->all();
            foreach($institutionBankData as $index => $bankDetails){
                $institutionBankDetails[$index] = $bankDetails;
                $checkBankDataInChallan = $feeChallanSettingRepository->getBankInChallanSetting($bankDetails->id);
                $institutionBankDetails[$index]['btn_status'] = "show";

                if($checkBankDataInChallan){
                    $institutionBankDetails[$index]['btn_status'] = "hide";
                }
            }

            return $institutionBankDetails;
        }

        // Get particular institutionBankDetails
        public function find($id){

            $institutionBankDetailsRepository = new InstitutionBankDetailsRepository();
            $institutionBankDetails = $institutionBankDetailsRepository->fetch($id);

            return $institutionBankDetails;
        }

        // Insert institutionBankDetails
        public function add($institutionBankDetailsData){

            $institutionBankDetailsRepository = new InstitutionBankDetailsRepository();
            
            $institutionId = $institutionBankDetailsData->id_academic;
            $academicYear = $institutionBankDetailsData->id_institute;

            $insertedCount = 0;

            foreach($institutionBankDetailsData->bank_name as $index => $bankName){
                $branchName = $institutionBankDetailsData->branch_name[$index];
                $accountNumber = $institutionBankDetailsData->account_number[$index];
                $ifscCode = $institutionBankDetailsData->ifsc_code[$index];

                $check = InstitutionBankDetails::where('account_number', $accountNumber)->first();

                if(!$check){

                    $data = array(
                        'id_institute' => $institutionId,
                        'id_academic' => $academicYear,
                        'bank_name' => $bankName,
                        'branch_name' => $branchName,
                        'account_number' => $accountNumber,
                        'ifsc_code' => $ifscCode,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                    );

                    $storeData = $institutionBankDetailsRepository->store($data);
                    if($storeData){
                        $insertedCount++;
                    }
                } 
            }

            if($insertedCount > 0){
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

        // Update institutionBankDetails
        public function update($institutionBankDetailsData, $id){

            $institutionBankDetailsRepository = new InstitutionBankDetailsRepository();

            $bankName = $institutionBankDetailsData->bank_name;
            $branchName = $institutionBankDetailsData->branch_name;
            $accountNumber = $institutionBankDetailsData->account_number;
            $ifscCode = $institutionBankDetailsData->ifsc_code;

            $check = InstitutionBankDetails::where('account_number', $accountNumber)
                                ->where('id', '!=', $id)->first();

            if(!$check){

                $institutionBankDetailsDetails = $institutionBankDetailsRepository->fetch($id);

                $institutionBankDetailsDetails->bank_name = $bankName;
                $institutionBankDetailsDetails->branch_name = $branchName;$institutionBankDetailsDetails->account_number = $accountNumber;
                $institutionBankDetailsDetails->ifsc_code = $ifscCode;
                $institutionBankDetailsDetails->modified_by = Session::get('userId');
                $institutionBankDetailsDetails->updated_at = Carbon::now();

                $updateData = $institutionBankDetailsRepository->update($institutionBankDetailsDetails);

                if($updateData){
                    $signal = 'success';
                    $msg = 'Data updated successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error updating data!';
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

        // Delete institutionBankDetails
        public function delete($id){

            $institutionBankDetailsRepository = new InstitutionBankDetailsRepository();

            $institutionBankDetails = $institutionBankDetailsRepository->delete($id);

            if($institutionBankDetails){

                $signal = 'success';
                $msg = 'Deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

         // Deleted grade records
         public function getDeletedRecords($allSessions){

            $institutionBankDetailsRepository = new InstitutionBankDetailsRepository();
            $data = $institutionBankDetailsRepository->allDeleted($allSessions);
            return $data;
        }

        // Restore grade records
        public function restore($id){

            $institutionBankDetailsRepository = new InstitutionBankDetailsRepository();

            $data = $institutionBankDetailsRepository->restore($id);

            if($data){

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
