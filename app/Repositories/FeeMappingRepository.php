<?php
    namespace App\Repositories;
    use App\Models\FeeMapping;
    use App\Models\FeeCategory;
    use App\Interfaces\FeeMappingRepositoryInterface;
    use DB;

    class FeeMappingRepository implements FeeMappingRepositoryInterface{

        public function all(){
            return FeeMapping::all();
        }

        public function store($data){
            return FeeMapping::create($data);
        }

        public function getHeadingMapping($idFeeHeading, $idFeeCategory){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return FeeMapping::where('id_fee_category', $idFeeCategory)->where('id_fee_heading', $idFeeHeading)->where('id_institute', $institutionId)->where('id_academic_year', $academicId)->first();
        }                

        public function getAcademicHeadingMapping($idFeeHeadingMapping, $idAcademic, $allSessions){

            $institutionId = $allSessions['institutionId'];
            
            return FeeMapping::where('id', $idFeeHeadingMapping)
            ->where('id_institute', $institutionId)
            ->where('id_academic_year', $idAcademic)
            ->first();
        }        

        public function fetchCategoryHeadingFromMapping($idFeeCategory, $allSessions){            

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return FeeMapping::where('id_fee_category', $idFeeCategory)
                        ->where('id_institute', $institutionId)
                        ->where('id_academic_year', $academicId)
                        ->get();
        }

        public function fetch($id){
            return FeeMapping::find($id);
        }

        public function update($data){
           return $data->save();
        }

        public function delete($id){
            return FeeMapping::find($id)->delete();
        }

        public function getFeeCategory($allSessions){

            DB::enableQueryLog();
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $feeCategory = FeeCategory::join('tbl_fee_mapping', 'tbl_fee_mapping.id_fee_category', '=', 'tbl_fee_category.id')
                        ->where('id_institute', $institutionId)
                        ->where('id_academic_year', $academicId)
                        ->select('tbl_fee_category.*')
                        ->groupBy('tbl_fee_mapping.id_fee_category')
                        ->get();
            // dd(DB::getQueryLog());
            return $feeCategory;
        }

        public function getReceiptSettingCategory($idSettingFeeCategory, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $feeCategory = FeeCategory::leftJoin('tbl_fee_mapping', 'tbl_fee_mapping.id_fee_category', '=', 'tbl_fee_category.id')
                        ->where('tbl_fee_mapping.id_institute', $institutionId)
                        ->where('tbl_fee_mapping.id_academic_year', $academicId)
                        ->whereNotIn('tbl_fee_mapping.id_fee_category', $idSettingFeeCategory)
                        ->select('tbl_fee_category.*')
                        ->groupBy('tbl_fee_mapping.id_fee_category')
                        ->get();
                        
            return $feeCategory;
        }

        public function getFeeCategoryDetail($idFeeHeadingMapping, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            
            return FeeMapping::select('tbl_fee_category.*')
                    ->join('tbl_fee_category', 'tbl_fee_category.id', '=', 'tbl_fee_mapping.id_fee_category')
                    ->where('tbl_fee_mapping.id', $idFeeHeadingMapping)
                    ->where('tbl_fee_mapping.id_institute', $institutionId)
                    ->where('tbl_fee_mapping.id_academic_year', $academicId)
                    ->first();
        }
        
    }

