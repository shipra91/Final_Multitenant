<?php 
    namespace App\Repositories;
    use App\Models\FeeAssignDetail;
    use App\Interfaces\FeeAssignDetailRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;
    use Session;
    use DB;

    class FeeAssignDetailRepository implements FeeAssignDetailRepositoryInterface{

        public function all($idStudent, $idFeeCategory, $idAcademic, $allSessions){
            DB::enableQueryLog();
            
            $institutionId = $allSessions['institutionId'];

            $feeAssigDetail =  FeeAssignDetail::join('tbl_fee_assign', 'tbl_fee_assign.id', '=', 'tbl_fee_assign_details.id_fee_assign')
                                ->leftJoin('tbl_fee_mapping', 'tbl_fee_assign_details.id_fee_heading', '=', 'tbl_fee_mapping.id')
                                ->where('tbl_fee_assign.id_institution', $institutionId)
                                ->where('tbl_fee_assign.id_academic', $idAcademic)
                                ->where('tbl_fee_assign.id_student', $idStudent)
                                ->where('tbl_fee_assign.id_fee_category', $idFeeCategory)
                                ->where('tbl_fee_assign_details.action_type', 'ASSIGNED')
                                ->whereNull('tbl_fee_assign.deleted_at')
                                ->whereNull('tbl_fee_assign_details.deleted_at')
                                ->select('tbl_fee_assign_details.*','tbl_fee_mapping.display_name')
                                ->orderBy('tbl_fee_mapping.display_name', 'ASC')
                                ->orderBy('tbl_fee_assign_details.installment_no', 'ASC')
                                ->get();  
            return $feeAssigDetail;          
        }

        public function store($data){
            return FeeAssignDetail::create($data);
        }        

        public function fetch($id){
            return FeeAssignDetail::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($idFeeAssign, $actionType){
            return FeeAssignDetail::where('id_fee_assign', $idFeeAssign)->where('action_type', $actionType)->delete();
        }

        public function fetchConcession($idFeeHeading, $idStudent, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            DB::enableQueryLog();

            $allConcessions = FeeAssignDetail::select(\DB::raw('SUM(tbl_fee_assign_details.amount) as amount'))
            ->join('tbl_fee_assign', 'tbl_fee_assign.id', '=', 'tbl_fee_assign_details.id_fee_assign')
            ->where('tbl_fee_assign_details.id_fee_heading', $idFeeHeading)
            ->where('tbl_fee_assign.id_student', $idStudent)
            ->where('action_type', 'CONCESSION')
            ->where('concession_approved', 'YES')
            ->whereNull('tbl_fee_assign.deleted_at')
            ->where('id_institution', $institutionId)
            ->where('id_academic', $academicYear)->first();
            // dd(DB::getQueryLog());
            // dd($allConcessions);
            return $allConcessions;
        }

        public function fetchAssignedAmount($idFeeHeading, $idStudent, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            DB::enableQueryLog();

            $totalAssignedAmountPerHeading = FeeAssignDetail::select(\DB::raw('SUM(tbl_fee_assign_details.amount) as amount'))
            ->join('tbl_fee_assign', 'tbl_fee_assign.id', '=', 'tbl_fee_assign_details.id_fee_assign')
            ->where('tbl_fee_assign_details.id_fee_heading', $idFeeHeading)
            ->where('tbl_fee_assign.id_student', $idStudent)
            ->where('action_type', 'ASSIGNED')
            ->whereNull('tbl_fee_assign.deleted_at')
            ->where('id_institution', $institutionId)
            ->where('id_academic', $academicYear)->first();
            // dd(DB::getQueryLog());
            // dd($allConcessions);
            return $totalAssignedAmountPerHeading;
        }

        public function fetchApprovedConcession($idFeeHeading, $idStudent, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            DB::enableQueryLog();

            $allConcessions = FeeAssignDetail::select(\DB::raw('SUM(tbl_fee_assign_details.amount) as amount'))
            ->join('tbl_fee_assign', 'tbl_fee_assign.id', '=', 'tbl_fee_assign_details.id_fee_assign')
            ->where('tbl_fee_assign_details.id_fee_heading', $idFeeHeading)
            ->where('tbl_fee_assign.id_student', $idStudent)
            ->where('action_type', 'CONCESSION')
            ->where('concession_approved', 'YES')
            ->whereNull('tbl_fee_assign.deleted_at')
            ->where('id_institution', $institutionId)
            ->where('id_academic', $academicYear)->first();
            // dd(DB::getQueryLog());
            // dd($allConcessions);
            return $allConcessions;
        }

        public function fetchAddition($idFeeHeading, $idStudent, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            DB::enableQueryLog();

            $allConcessions = FeeAssignDetail::select(\DB::raw('SUM(tbl_fee_assign_details.amount) as amount'))
            ->join('tbl_fee_assign', 'tbl_fee_assign.id', '=', 'tbl_fee_assign_details.id_fee_assign')
            ->where('tbl_fee_assign_details.id_fee_heading', $idFeeHeading)
            ->where('tbl_fee_assign.id_student', $idStudent)
            ->where('action_type', 'ADDITION')
            ->whereNull('tbl_fee_assign.deleted_at')
            ->where('id_institution', $institutionId)
            ->where('id_academic', $academicYear)->first();
            // dd(DB::getQueryLog());
            // dd($allConcessions);
            return $allConcessions;
        }

        //GET TOTAL CONCESSION AMOUNT
        public function fetchTotalFeeConcessionAmount($idStudent){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            DB::enableQueryLog();

            $concessionAmount = FeeAssignDetail::select(\DB::raw('SUM(tbl_fee_assign_details.amount) as amount'))
            ->join('tbl_fee_assign', 'tbl_fee_assign.id', '=', 'tbl_fee_assign_details.id_fee_assign')
            ->where('tbl_fee_assign.id_student', $idStudent)
            ->where('action_type', 'CONCESSION')
            ->where('concession_approved', 'YES')
            ->whereNull('tbl_fee_assign.deleted_at')
            ->where('id_institution', $institutionId)
            ->where('id_academic', $academicYear)->first();
            // dd(DB::getQueryLog());
            // dd($allConcessions);
            return $concessionAmount;
        }

        //GET TOTAL ADDITION AMOUNT
        public function fetchTotalFeeAdditionAmount($idStudent){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            DB::enableQueryLog();

            $additionAmount = FeeAssignDetail::select(\DB::raw('SUM(tbl_fee_assign_details.amount) as amount'))
            ->join('tbl_fee_assign', 'tbl_fee_assign.id', '=', 'tbl_fee_assign_details.id_fee_assign')
            ->where('tbl_fee_assign.id_student', $idStudent)
            ->where('action_type', 'ADDITION')
            ->whereNull('tbl_fee_assign.deleted_at')
            ->where('id_institution', $institutionId)
            ->where('id_academic', $academicYear)->first();
            // dd(DB::getQueryLog());
            // dd($allConcessions);
            return $additionAmount;
        }

        public function getAcademicTotalAssignedAmount($idStudent, $idAcademicYear, $allSessions){
            DB::enableQueryLog();

            $institutionId = $allSessions['institutionId'];

             $feeAssignData = FeeAssignDetail::select(\DB::raw('SUM(tbl_fee_assign_details.amount) as amount'))
            ->join('tbl_fee_assign', 'tbl_fee_assign.id', '=', 'tbl_fee_assign_details.id_fee_assign')
            ->where('tbl_fee_assign.id_student', $idStudent)
            ->where('action_type', 'ASSIGNED')
            ->whereNull('tbl_fee_assign.deleted_at')
            ->where('id_institution', $institutionId)
            ->where('id_academic', $idAcademicYear)->first();
            // dd(DB::getQueryLog());
            return $feeAssignData;
        }

        public function getAcademicTotalAdditionalAmount($idStudent, $idAcademicYear, $allSessions){
            DB::enableQueryLog();

            $institutionId = $allSessions['institutionId'];

             $additionAmount = FeeAssignDetail::select(\DB::raw('SUM(tbl_fee_assign_details.amount) as amount'))
            ->join('tbl_fee_assign', 'tbl_fee_assign.id', '=', 'tbl_fee_assign_details.id_fee_assign')
            ->where('tbl_fee_assign.id_student', $idStudent)
            ->where('action_type', 'ADDITION')
            ->whereNull('tbl_fee_assign.deleted_at')
            ->where('id_institution', $institutionId)
            ->where('id_academic', $idAcademicYear)->first();
            // dd(DB::getQueryLog());
            return $additionAmount;
        }

        public function getAcademicTotalConcessionAmount($idStudent, $idAcademicYear, $allSessions){
            DB::enableQueryLog();

            $institutionId = $allSessions['institutionId'];

            $concessionAmount = FeeAssignDetail::select(\DB::raw('SUM(tbl_fee_assign_details.amount) as amount'))
            ->join('tbl_fee_assign', 'tbl_fee_assign.id', '=', 'tbl_fee_assign_details.id_fee_assign')
            ->where('tbl_fee_assign.id_student', $idStudent)
            ->where('action_type', 'CONCESSION')
            ->where('concession_approved', 'YES')
            ->whereNull('tbl_fee_assign.deleted_at')
            ->where('id_institution', $institutionId)
            ->where('id_academic', $idAcademicYear)->first();
           //dd(DB::getQueryLog());
            return $concessionAmount;
        }
        
        public function getCategoryTotalConcessionAmount($idFeeAssigned, $allSessions){

            DB::enableQueryLog();

            $institutionId = $allSessions['institutionId'];
            $idAcademicYear = $allSessions['academicYear'];
            $organizationId = $allSessions['organizationId'];

            $concessionAmount = FeeAssignDetail::select(\DB::raw('SUM(tbl_fee_assign_details.amount) as amount'))
            ->join('tbl_fee_assign', 'tbl_fee_assign.id', '=', 'tbl_fee_assign_details.id_fee_assign')
            ->where('id_fee_assign', $idFeeAssigned)
            ->where('action_type', 'CONCESSION') 
            ->where('concession_approved', 'YES')
            ->whereNull('tbl_fee_assign.deleted_at')     
            ->where('id_institution', $institutionId)
            ->where('id_academic', $idAcademicYear)
            ->first();
            
            return $concessionAmount;
        }

        public function fetchStudentFeeConcessionDetail($idStudent, $idFeeCategory, $idFeeHeading, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            DB::enableQueryLog();

            $concessionDetail = FeeAssignDetail::select()
            ->join('tbl_fee_assign', 'tbl_fee_assign.id', '=', 'tbl_fee_assign_details.id_fee_assign')
            ->where('tbl_fee_assign.id_student', $idStudent)
            ->where('tbl_fee_assign.id_fee_category', $idFeeCategory)
            ->where('tbl_fee_assign_details.id_fee_heading', $idFeeHeading)
            ->where('action_type', 'CONCESSION')
            ->where('concession_approved', 'YES')   
            ->whereNull('tbl_fee_assign.deleted_at')         
            ->where('id_institution', $institutionId)
            ->where('id_academic', $academicYear)->get();
            // dd(DB::getQueryLog());
            // dd($concessionDetail);
            return $concessionDetail;
        }

        

        public function fetchFeeHeadingTotalAmount($idFeeCategory, $idFeeHeading, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            DB::enableQueryLog();

            $concessionAmount = FeeAssignDetail::select(\DB::raw('SUM(tbl_fee_assign_details.amount) as amount'))
            ->join('tbl_fee_assign', 'tbl_fee_assign.id', '=', 'tbl_fee_assign_details.id_fee_assign')
            ->where('tbl_fee_assign.id_fee_category', $idFeeCategory)
            ->where('tbl_fee_assign_details.id_fee_heading', $idFeeHeading)
            ->where('action_type', 'CONCESSION')
            ->where('concession_approved', 'YES')
            ->whereNull('tbl_fee_assign.deleted_at')            
            ->where('id_institution', $institutionId)
            ->where('id_academic', $academicYear)->first();
            // dd(DB::getQueryLog());
            // dd($concessionDetail);
            return $concessionAmount;
        }
    }
?>