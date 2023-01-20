<?php
    namespace App\Repositories;
    use App\Models\FeeChallanDetail;
    use App\Interfaces\FeeChallanDetailRepositoryInterface;
    use Storage;
    use Session;
    use DB;

    class FeeChallanDetailRepository implements FeeChallanDetailRepositoryInterface{

        public function all(){
            return FeeChallanDetail::all();
        }

        public function store($data){
            return FeeChallanDetail::create($data);
        }

        public function fetch($idFeeCategory, $idFeeChallan){
            
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            return FeeChallanDetail::where('id_fee_category', $idFeeCategory)->where('id_fee_challan', $idFeeChallan)
                                    ->get();
        }

        public function getChallan($idFeeChallan){
            
            return FeeChallanDetail::where('id_fee_challan', $idFeeChallan)
                                    ->get();
        }

        public function search($id){
            return FeeChallanDetail::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return FeeChallanDetail::find($id)->delete();
        }

        public function getChallanCategories($idFeeChallan){
            
            return FeeChallanDetail::join('tbl_create_fee_challans', 'tbl_create_fee_challans.id', '=', 'tbl_fee_challan_details.id_fee_challan')
            ->where('id_fee_challan', $idFeeChallan)
            ->groupBy('tbl_fee_challan_details.id_fee_category')->get();
        }

        public function totalChallanAmountCategoryWise($idFeeChallan, $idFeeCategory){
            DB::enableQueryLog();

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $paidHistory = FeeChallanDetail::select(\DB::raw('SUM(tbl_fee_challan_details.fee_amount + tbl_fee_challan_details.gst_received) as paid_amount'))
            ->join('tbl_create_fee_challans', 'tbl_create_fee_challans.id', '=', 'tbl_fee_challan_details.id_fee_challan')
            ->where('tbl_create_fee_challans.id_institute', $institutionId)
            ->where('tbl_create_fee_challans.id_academic_year', $academicId)
            ->where('tbl_fee_challan_details.id_fee_category', $idFeeCategory)
            ->where('tbl_create_fee_challans.id', $idFeeChallan)
            ->first();

            // dd($paidHistory);
            return $paidHistory;
        }
    }
?>