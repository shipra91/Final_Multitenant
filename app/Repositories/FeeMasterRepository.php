<?php
    namespace App\Repositories;
    use App\Models\FeeMaster;
    use App\Interfaces\FeeMasterRepositoryInterface;
    use Session;
    use DB;

    class FeeMasterRepository implements FeeMasterRepositoryInterface{

        public function all($idFeeCategory, $standard, $fee_type, $installment_type){

           // DB::enableQueryLog();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $feeMaterData = FeeMaster::where('id_institute', $institutionId)
                            ->where('id_academic_year', $academicId)
                            ->where('id_fee_category', $idFeeCategory)
                            ->where('id_institution_standard', $standard)
                            ->where('id_fee_type', $fee_type)
                            ->where('installment_type', $installment_type)
                            ->first();
            // dd(DB::getQueryLog());
            return $feeMaterData;
        }  
        
        public function getAll(){

            // DB::enableQueryLog();
             $allSessions = session()->all();
             $institutionId = $allSessions['institutionId'];
             $academicId = $allSessions['academicYear'];
 
             $feeMaterData = FeeMaster::where('id_institute', $institutionId)
                             ->where('id_academic_year', $academicId)
                             ->get();
             // dd(DB::getQueryLog());
             return $feeMaterData;
         }  

        public function standardFeeCategory($standardId){
            
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return FeeMaster::where('id_institution_standard', $standardId)
                        ->where('id_institute', $institutionId)
                        ->where('id_academic_year', $academicId)
                        ->get()
                        ->groupBY("id_fee_category");
        }

        public function getInstallmentType($idFeeCategory, $standard, $fee_type){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $feeMatserData = FeeMaster::where('id_institute', $institutionId)
                            ->where('id_academic_year', $academicId)
                            ->where('id_fee_category', $idFeeCategory)
                            ->where('id_institution_standard', $standard)
                            ->where('id_fee_type', $fee_type)
                            ->first();
            // dd(DB::getQueryLog());
            return $feeMatserData;
        }

        

        public function getInstallmentTypeDetails($standard, $fee_type){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $feeMatserData = FeeMaster::where('id_institute', $institutionId)
                            ->where('id_academic_year', $academicId)
                            ->where('id_institution_standard', $standard)
                            ->where('id_fee_type', $fee_type)
                            ->get();
            // dd(DB::getQueryLog());
            return $feeMatserData;
        }

        public function store($data){
            return FeeMaster::create($data);
        }

        public function fetch($id){
            return FeeMaster::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return FeeMaster::find($id)->delete();
        }

        public function getFeeTypeAmount($request){

           DB::enableQueryLog();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            
            $standard = $request['standard'];
            $fee_type = $request['feeType'];
            $idFeeCategory = $request['idFeeCategory'];
            $feeAmount = 0;

            $feeMasterData = $this->getInstallmentType($idFeeCategory, $standard, $fee_type);

            if($feeMasterData){

                if($feeMasterData->installment_type == 'HEADING_WISE'){

                    $feeTotalData = FeeMaster::select(\DB::raw('SUM(tbl_fee_assign_setting.amount) as amount'))
                            ->join('tbl_fee_assign_setting', 'tbl_fee_master.id', '=', 'tbl_fee_assign_setting.id_fee_master')
                            ->where('id_institute', $institutionId)
                            ->where('id_academic_year', $academicId)
                            ->where('id_fee_category', $idFeeCategory)
                            ->where('id_institution_standard', $standard)
                            ->where('id_fee_type', $fee_type)
                            ->first();

                }else{

                    $feeTotalData = FeeMaster::select('tbl_fee_category_setting.amount as amount')
                            ->join('tbl_fee_category_setting', 'tbl_fee_master.id', '=', 'tbl_fee_category_setting.id_fee_master')
                            ->where('id_institute', $institutionId)
                            ->where('id_academic_year', $academicId)
                            ->where('id_fee_category', $idFeeCategory)
                            ->where('id_institution_standard', $standard)
                            ->where('id_fee_type', $fee_type)
                            ->first();
                }

                if($feeTotalData){
                    $feeAmount = $feeTotalData->amount;
                }

            }
            
            // dd(DB::getQueryLog());
            return $feeAmount;
            
        }              

        public function standardFeeType($standardId){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            
            return FeeMaster::where('id_institution_standard', $standardId)
                        ->where('id_institute', $institutionId)
                        ->where('id_academic_year', $academicId)
                        ->get()
                        ->groupBY("id_fee_type");
        }

        public function getFeeMasterForFeeCategory($idFeeCategory) { 

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            
            return FeeMaster::where('id_institute', $institutionId)
                        ->where('id_academic_year', $academicId)
                        ->where('id_fee_category', $idFeeCategory)
                        ->get();
        }

        public function getFeeMasterDetails($standardIds, $fee_type, $idFeeCategory){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $feeMatserData = FeeMaster::where('id_institute', $institutionId)
                            ->where('id_academic_year', $academicId)
                            ->whereIn('id_institution_standard', $standardIds)
                            ->where('id_fee_type', $fee_type)
                            ->where('id_fee_category', $idFeeCategory)
                            ->first();
            // dd(DB::getQueryLog());
            return $feeMatserData;
        }

        public function checkFeeTypeUsedInFeemaster($idFeeType){
            return FeeMaster::where('id_fee_type', $idFeeType)->first();
        }
    }

