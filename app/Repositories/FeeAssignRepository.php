<?php 
    namespace App\Repositories;
    use App\Models\FeeAssign;
    use App\Interfaces\FeeAssignRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;
    use Session;
    use DB;

    class FeeAssignRepository implements FeeAssignRepositoryInterface{

        public function all(){
            return FeeAssign::all();            
        }

        public function store($data){
            return FeeAssign::create($data);
        }        

        public function fetch($id){
            return FeeAssign::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($idStudent){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return FeeAssign::where('id_student', $idStudent)->where('id_institution', $institutionId)
            ->where('id_academic', $academicYear)->delete();
        }
                
        //GET STUDENT FEE TYPE
        public function fetchStudentFeeType($idStudent){
            DB::enableQueryLog();

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $feeType = FeeAssign::select('tbl_fee_assign.id_fee_type')
            ->where('tbl_fee_assign.id_student', $idStudent)
            ->where('id_institution', $institutionId)
            ->where('id_academic', $academicYear)->first();
            // dd(DB::getQueryLog());
            return $feeType;
        }
                
        //GET STUDENT FEE TYPE
        public function fetchStudentFeeCategory($idStudent, $idAcademic, $allSessions){
            DB::enableQueryLog();
            
            $institutionId = $allSessions['institutionId'];

            $feeCAtegories = FeeAssign::select('tbl_fee_category.*')
            ->join('tbl_fee_category', 'tbl_fee_category.id', '=', 'tbl_fee_assign.id_fee_category')
            ->where('tbl_fee_assign.id_student', $idStudent)
            ->where('tbl_fee_assign.id_institution', $institutionId)
            ->where('tbl_fee_assign.id_academic', $idAcademic)
            ->get();
            // dd(DB::getQueryLog());
            return $feeCAtegories;
        }

        public function checkFeeAssignAvaibility($idStandard, $student, $idFeeCategory, $feeType, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $organizationId = $allSessions['organizationId'];

            $check = FeeAssign::where('id_organization', $organizationId)
                        ->where('id_institution', $institutionId)
                        ->where('id_academic', $academicId)
                        ->where('id_standard', $idStandard)
                        ->where('id_student', $student)
                        ->where('id_fee_category', $idFeeCategory)
                        ->where('id_fee_type', $feeType)->first();
            return $check;
        }

        public function getAssignedAmount($data){
            DB::enableQueryLog();
            $feeAssignData = FeeAssign::where('id_student', $data['id_student'])
            ->where('id_standard', $data['id_institution_standard'])
            ->where('id_fee_category', $data['id_fee_category'])
            ->where('id_institution', $data['id_institute'])
            ->where('id_academic', $data['id_academic_year'])
            ->where('id_fee_type', $data['id_fee_type'])->first();
            // dd(DB::getQueryLog());
            return $feeAssignData;
        }        

        public function getPendingPaymentDetails($idStudent, $idAcademicYear){
            DB::enableQueryLog();

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $paidHistoryArray = array();

            $paidHistory = CollectionDetail::select(\DB::raw('SUM(tbl_fee_collection_details.fee_amount) as paid_amount'), 'tbl_fee_collections.*')
            ->join('tbl_fee_collections', 'tbl_fee_collections.id', '=', 'tbl_fee_collection_details.id')
            ->where('tbl_fee_collections.id_student', $idStudent)
            ->where('tbl_fee_collections.id_institute', $institutionId)
            ->where('tbl_fee_collections.cancelled', 'NO')
            ->where('tbl_fee_collections.id_academic_year', $idAcademicYear)->get();
            // dd($paidHistory);
            
            foreach($paidHistory as $index => $history){
                if($history->paid_amount !=''){
                    $paidHistoryArray[$index]['paid_date'] = $history->paid_date;
                    $paidHistoryArray[$index]['payment_mode'] = $history->payment_mode;
                    $paidHistoryArray[$index]['paid_amount'] = $history->paid_amount;
                    $paidHistoryArray[$index]['receipt_prefix'] = $history->receipt_prefix;
                    $paidHistoryArray[$index]['receipt_no'] = $history->receipt_no;
                    $paidHistoryArray[$index]['collected_by'] = $history->collected_by;
                }
            }
            return $paidHistoryArray;
        }

        public function studentConcessionAssignedDetails($idStudent, $allSessions) {
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            DB::enableQueryLog();
            return FeeAssign::select('tbl_fee_assign.*', 'tbl_fee_assign_details.*')
            ->join('tbl_fee_assign_details', 'tbl_fee_assign.id', '=', 'tbl_fee_assign_details.id_fee_assign')
            ->where('tbl_fee_assign.id_student', $idStudent)
            ->where('tbl_fee_assign.id_institution', $institutionId)
            ->where('tbl_fee_assign.id_academic', $academicId)
            ->where('tbl_fee_assign_details.action_type', 'CONCESSION')
            ->get();
           
        }

        public function getAssignedData($idInstitutionStandard, $idFeeCategory, $idFeeType, $installmentType){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $organizationId = $allSessions['organizationId'];

            $check = FeeAssign::where('id_organization', $organizationId)
                        ->where('id_institution', $institutionId)
                        ->where('id_academic', $academicId)
                        ->where('id_standard', $idInstitutionStandard)
                        ->where('installment_type', $installmentType)
                        ->where('id_fee_category', $idFeeCategory)
                        ->where('id_fee_type', $idFeeType)->first();
            return $check;
        }

        public function studentCategoryFeeAssign($idStandard, $student, $idFeeCategory, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $organizationId = $allSessions['organizationId'];

            $check = FeeAssign::where('id_organization', $organizationId)
                        ->where('id_institution', $institutionId)
                        ->where('id_academic', $academicId)
                        ->where('id_standard', $idStandard)
                        ->where('id_student', $student)
                        ->where('id_fee_category', $idFeeCategory)
                        ->first();
            return $check;
        }
    }
?>