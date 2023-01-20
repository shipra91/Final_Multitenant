<?php
    namespace App\Repositories;
    use App\Models\CollectionDetail;
    use App\Interfaces\FeeCollectionDetailRepositoryInterface;
    use Storage;
    use Session;
    use DB;

    class FeeCollectionDetailRepository implements FeeCollectionDetailRepositoryInterface{

        public function all(){
            return CollectionDetail::all();
        }

        public function store($data){
            return CollectionDetail::create($data);
        }

        public function fetch($id){
            return CollectionDetail::find($id);
        }

        public function search($id){
            return CollectionDetail::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return CollectionDetail::find($id)->delete();
        }
        
        public function getReceipt($idFeeCollection){
            
            return CollectionDetail::where('id_fee_collection', $idFeeCollection)->get();
        }
        
        public function getReceiptCategories($idFeeCollection){
            
            return CollectionDetail::join('tbl_fee_collections', 'tbl_fee_collections.id', '=', 'tbl_fee_collection_details.id_fee_collection')
                                    ->join('tbl_fee_mapping', 'tbl_fee_mapping.id', '=', 'tbl_fee_collection_details.id_fee_mapping_heading')
                                    ->where('id_fee_collection', $idFeeCollection)
                                    ->groupBy('tbl_fee_mapping.id_fee_category')->get();
        }


        public function getPaymentDetails($idStudent, $idAcademicYear, $allSessions){
            DB::enableQueryLog();

            $institutionId = $allSessions['institutionId'];
            $paidHistoryArray = array();

            $paidHistory = CollectionDetail::select(\DB::raw('SUM(tbl_fee_collection_details.fee_amount + tbl_fee_collection_details.gst_received) as paid_amount'), 'tbl_fee_collections.*')
            ->join('tbl_fee_collections', 'tbl_fee_collections.id', '=', 'tbl_fee_collection_details.id_fee_collection')
            ->where('tbl_fee_collections.id_student', $idStudent)
            ->where('tbl_fee_collections.id_institute', $institutionId)
            ->where('tbl_fee_collections.cancelled', 'NO')
            ->where('tbl_fee_collections.id_academic_year', $idAcademicYear)
            ->groupBy('tbl_fee_collections.created_at')
            ->get();
            // dd($paidHistory);
            
            foreach($paidHistory as $index => $history){
                if($history->paid_amount !=''){
                    $paidHistoryArray[$index]['idFeeCollection'] = $history->id;
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

        public function getHeadingWiseInstallmentPaymentDetails($idStudent, $idFeeHeading, $installmentNo, $idAcademicYear, $allSessions){
            DB::enableQueryLog();

            $institutionId = $allSessions['institutionId'];
            $paidHistoryArray = array();

            $installmentPaymentDetail = CollectionDetail::select('tbl_fee_collection_details.*')
            ->join('tbl_fee_collections', 'tbl_fee_collections.id', '=', 'tbl_fee_collection_details.id_fee_collection')
            ->where('tbl_fee_collections.id_student', $idStudent)
            ->where('tbl_fee_collections.id_institute', $institutionId)
            ->where('tbl_fee_collections.cancelled', 'NO')
            ->where('tbl_fee_collection_details.id_fee_mapping_heading', $idFeeHeading)
            ->where('tbl_fee_collection_details.installment_no', $installmentNo)
            ->where('tbl_fee_collections.id_academic_year', $idAcademicYear)
            ->get();
            
            return $installmentPaymentDetail;
        }

        public function getFeePaymentDetails($idStudent, $allSessions){
            DB::enableQueryLog();
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $paidHistoryArray = array();

            $paidHistory = CollectionDetail::select(\DB::raw('SUM(tbl_fee_collection_details.fee_amount + tbl_fee_collection_details.gst_received) as paid_amount'), 'tbl_fee_collections.*')
            ->join('tbl_fee_collections', 'tbl_fee_collections.id', '=', 'tbl_fee_collection_details.id_fee_collection')
            ->where('tbl_fee_collections.id_student', $idStudent)
            ->where('tbl_fee_collections.id_institute', $institutionId)
            ->where('tbl_fee_collections.id_academic_year', $academicId)
            ->groupBy('tbl_fee_collections.created_at')
            ->get();
            return $paidHistory;
            // dd($paidHistory);
        }

        public function fetchPaidAmount($idFeeHeading, $idStudent, $allSessions){
            DB::enableQueryLog();

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $paidHistoryArray = array();

            $paidAmount = CollectionDetail::select(\DB::raw('SUM(tbl_fee_collection_details.fee_amount + tbl_fee_collection_details.gst_received) as paid_amount'))
            ->join('tbl_fee_collections', 'tbl_fee_collections.id', '=', 'tbl_fee_collection_details.id_fee_collection')
            ->where('tbl_fee_collections.id_student', $idStudent)
            ->where('tbl_fee_collection_details.id_fee_mapping_heading', $idFeeHeading)
            ->where('tbl_fee_collections.cancelled', 'NO')
            ->where('tbl_fee_collections.id_institute', $institutionId)
            ->where('tbl_fee_collections.id_academic_year', $academicId)
            ->first();
            return $paidAmount;
            // dd($paidAmount);
        }
        
        public function totalPaidAmountCategoryWise($idStudent, $allSessions){
            DB::enableQueryLog();
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $paidHistory = CollectionDetail::select(\DB::raw('SUM(tbl_fee_collection_details.fee_amount + tbl_fee_collection_details.gst_received) as paid_amount'))
            ->join('tbl_fee_collections', 'tbl_fee_collections.id', '=', 'tbl_fee_collection_details.id_fee_collection')
            ->join('tbl_fee_mapping', 'tbl_fee_mapping.id', '=', 'tbl_fee_collection_details.id_fee_mapping_heading')
            ->where('tbl_fee_collections.id_student', $idStudent)
            ->where('tbl_fee_collections.id_institute', $institutionId)
            ->where('tbl_fee_collections.id_academic_year', $academicId)
            ->first();

            // dd($paidHistory);
            return $paidHistory;
        }
        
        public function totalCollectedAmountCategoryWise($idFeeCollection, $idStudent, $idFeeCategory, $allSessions){
            DB::enableQueryLog();

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $paidHistory = CollectionDetail::select(\DB::raw('SUM(tbl_fee_collection_details.fee_amount + tbl_fee_collection_details.gst_received) as paid_amount'))
            ->join('tbl_fee_collections', 'tbl_fee_collections.id', '=', 'tbl_fee_collection_details.id_fee_collection')
            ->join('tbl_fee_mapping', 'tbl_fee_mapping.id', '=', 'tbl_fee_collection_details.id_fee_mapping_heading')
            ->where('tbl_fee_collections.id_student', $idStudent)
            ->where('tbl_fee_collections.id_institute', $institutionId)
            ->where('tbl_fee_collections.id_academic_year', $academicId)
            ->where('tbl_fee_mapping.id_fee_category', $idFeeCategory)
            ->where('tbl_fee_collections.id', $idFeeCollection)
            ->first();

            // dd($paidHistory);
            return $paidHistory;
        }

        public function totalPaidAmount($idStudent, $academicId, $allSessions){
            DB::enableQueryLog();
            
            $institutionId = $allSessions['institutionId'];

            $paidHistory = CollectionDetail::select(\DB::raw('SUM(tbl_fee_collection_details.fee_amount + tbl_fee_collection_details.gst_received) as paid_amount'))
            ->join('tbl_fee_collections', 'tbl_fee_collections.id', '=', 'tbl_fee_collection_details.id_fee_collection')
            ->join('tbl_fee_mapping', 'tbl_fee_mapping.id', '=', 'tbl_fee_collection_details.id_fee_mapping_heading')
            ->where('tbl_fee_collections.id_student', $idStudent)
            ->where('tbl_fee_collections.id_institute', $institutionId)
            ->where('tbl_fee_collections.id_academic_year', $academicId)
            ->first();

            // dd($paidHistory);
            return $paidHistory;
        }
  
        public function getStudentFeeCollectionDetail($studentId, $fromDate, $toDate, $allSessions){
            DB::enableQueryLog();

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $paidHistoryArray = array();

            $paymentDetail = CollectionDetail::select('tbl_fee_collection_details.*', 'tbl_fee_collections.*')
            ->join('tbl_fee_collections', 'tbl_fee_collections.id', '=', 'tbl_fee_collection_details.id_fee_collection')
            ->where('tbl_fee_collections.id_student', $studentId)
            ->where('tbl_fee_collections.id_institute', $institutionId)
            ->where('tbl_fee_collections.id_academic_year', $academicId)
            ->where('tbl_fee_collections.cancelled', 'NO')
            ->whereBetween('tbl_fee_collections.paid_date', [$fromDate, $toDate])
            ->groupBy('tbl_fee_collection_details.id_fee_collection')
            ->get();

            // dd(DB::getQueryLog());
            return $paymentDetail;
        }
  
        public function getStudentFeeCancelledDetail($studentId){
            DB::enableQueryLog();

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $paidHistoryArray = array();

            $paymentDetail = CollectionDetail::select('tbl_fee_collection_details.*', 'tbl_fee_collections.*')
            ->join('tbl_fee_collections', 'tbl_fee_collections.id', '=', 'tbl_fee_collection_details.id_fee_collection')
            ->where('tbl_fee_collections.id_student', $studentId)
            ->where('tbl_fee_collections.id_institute', $institutionId)
            ->where('tbl_fee_collections.id_academic_year', $academicId)
            ->where('tbl_fee_collections.cancelled', 'YES')
            ->groupBy('tbl_fee_collection_details.id_fee_collection')
            ->get();

            // dd(DB::getQueryLog());
            return $paymentDetail;
        }


        public function getCollectionForFeeCategory($idFeeCategory, $studentId){
            DB::enableQueryLog();

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $paidHistoryArray = array();

            $paymentDetail = CollectionDetail::select('tbl_fee_collection_details.*', 'tbl_fee_collections.*')
            ->join('tbl_fee_collections', 'tbl_fee_collections.id', '=', 'tbl_fee_collection_details.id_fee_collection')
            ->where('tbl_fee_collections.id_student', $studentId)
            ->where('tbl_fee_collections.id_institute', $institutionId)
            ->where('tbl_fee_collections.id_academic_year', $academicId)
            ->where('tbl_fee_collections.cancelled', 'NO')
            ->where('tbl_fee_collection_details.id_fee_category', $idFeeCategory)
            ->first();

            // dd(DB::getQueryLog());
            return $paymentDetail;
        }

        
  
        public function getStudentFeeCancelledDetailWithDetail($studentId, $fromDate, $toDate, $allSessions){
            DB::enableQueryLog();

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $paidHistoryArray = array();

            $paymentDetail = CollectionDetail::select('tbl_fee_collection_details.*', 'tbl_fee_collections.*')
            ->join('tbl_fee_collections', 'tbl_fee_collections.id', '=', 'tbl_fee_collection_details.id_fee_collection')
            ->where('tbl_fee_collections.id_student', $studentId)
            ->where('tbl_fee_collections.id_institute', $institutionId)
            ->where('tbl_fee_collections.id_academic_year', $academicId)
            ->where('tbl_fee_collections.cancelled', 'YES')
            ->whereBetween('tbl_fee_collections.paid_date', [$fromDate, $toDate])
            ->groupBy('tbl_fee_collection_details.id_fee_collection')
            ->get();

            // dd(DB::getQueryLog());
            return $paymentDetail;
        }
    }
?>