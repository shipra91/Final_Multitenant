<?php
    namespace App\Repositories;
    use App\Models\FeeInstallment;
    use App\Interfaces\FeeInstallmentRepositoryInterface;
    use DB;
    
    class FeeInstallmentRepository implements FeeInstallmentRepositoryInterface{

        public function all($idFeeAssignSetting){
            return FeeInstallment::where('id_fee_assign', $idFeeAssignSetting)->orderBy('installment_no')->get();
        }

        public function store($data){
            return FeeInstallment::create($data);
        }

        public function fetch($id){
            return FeeInstallment::find($id);
        }

        public function search($idCategorySetting, $installmentNo){
            return FeeInstallment::where('id_fee_assign', $idCategorySetting)->where('installment_no', $installmentNo)->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($feeAssignId){
            return FeeInstallment::where('id_fee_assign', $feeAssignId)->delete();
        }


        public function fetchHeadingDetail($idFeeMaster){

            DB::enableQueryLog();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
 
            $response = FeeInstallment::join('tbl_fee_assign_setting', 'tbl_fee_assign_setting.id', '=', 'tbl_fee_installment.id_fee_assign')
            ->where('id_fee_master', $idFeeMaster)
            ->whereNull('tbl_fee_assign_setting.deleted_at')
            ->get(['tbl_fee_assign_setting.id_fee_heading', 'tbl_fee_assign_setting.amount as headingAmount', 'tbl_fee_installment.*']);
            // dd(DB::getQueryLog());
             // dd($response);
            return $response;
         }    
    }
