<?php
    namespace App\Repositories;
    use App\Models\FeeCollection;
    use App\Interfaces\FeeCollectionRepositoryInterface;
    use Storage;
    use Session;
    use DB;

    class FeeCollectionRepository implements FeeCollectionRepositoryInterface{

        public function all(){
            return FeeCollection::all();
        }

        public function store($data){
            return FeeCollection::create($data);
        }

        public function fetch($id){
            return FeeCollection::find($id);
        }

        public function search($id){
            return FeeCollection::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return FeeCollection::find($id)->delete();
        }

        public function totalPaid($idStudent, $idAcademicYear, $allSessions){
            DB::enableQueryLog();

            $institutionId = $allSessions['institutionId'];

            $paidAmount = FeeCollection::select(\DB::raw('SUM(tbl_fee_collections.amount_received +  tbl_fee_collections.gst) as amount'))
            ->where('tbl_fee_collections.id_student', $idStudent)
            ->where('id_institute', $institutionId)
            ->where('id_academic_year', $idAcademicYear)
            ->where('cancelled', 'NO')->first();
            // dd(DB::getQueryLog());
            return $paidAmount;
        }

        public function getMaxReceiptNo($idReceiptSetting, $idAcademicYear, $allSessions){
            
            $institutionId = $allSessions['institutionId'];

            $maxReceiptNo = FeeCollection::where('id_institute', $institutionId)
                            ->where('id_academic_year', $idAcademicYear)
                            ->where('id_receipt_setting', $idReceiptSetting)
                            ->max('receipt_no');
            
            return $maxReceiptNo;
        }

        public function getCollectionForReceiptSetting($idReceiptSetting, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $idAcademicYear = $allSessions['academicYear'];

            $feeCollectionDetails = FeeCollection::where('id_institute', $institutionId)
                            ->where('id_academic_year', $idAcademicYear)
                            ->where('id_receipt_setting', $idReceiptSetting)
                            ->get();
            
            return $feeCollectionDetails;
        }

        public function getCollectionForFeeCategory($idFeeCategory, $idStudent){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $idAcademicYear = $allSessions['academicYear'];

            $feeCollectionDetails = FeeCollection::where('id_institute', $institutionId)
                            ->where('id_academic_year', $idAcademicYear)
                            ->where('id_fee_category', $idFeeCategory)
                            ->first();
            
            return $feeCollectionDetails;
        }

        public function getCollectionForFeeMaster($idStandards, $idFeeType, $idFeeCategory, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $idAcademicYear = $allSessions['academicYear'];

            $feeCollectionDetails = FeeCollection::join('tbl_fee_assign','tbl_fee_assign.id_student', '=', 'tbl_fee_collections.id_student')
                            ->where('tbl_fee_assign.id_institution', $institutionId)
                            ->where('tbl_fee_assign.id_academic', $idAcademicYear)
                            ->whereIn('id_standard', $idStandards)
                            ->where('id_fee_category', $idFeeCategory)
                            ->where('id_fee_type', $idFeeType)
                            ->first();
            
            return $feeCollectionDetails;
        }
        
    }
?>