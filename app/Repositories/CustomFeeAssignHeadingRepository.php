<?php 
    namespace App\Repositories;
    use App\Models\CustomFeeAssignHeading;
    use App\Interfaces\CustomFeeAssignHeadingRepositoryInterface;

    class CustomFeeAssignHeadingRepository implements CustomFeeAssignHeadingRepositoryInterface{

        public function all(){
            return CustomFeeAssignHeading::all();            
        }

        public function store($data){
            return CustomFeeAssignHeading::create($data);
        }        

        public function fetch($id){
            return CustomFeeAssignHeading::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id){
            return CustomFeeAssignHeading::find($id)->delete();
        }

        public function getAmount($data){

            $headingData = CustomFeeAssignHeading::select(\DB::raw('SUM(tbl_custom_fee_assign_heading.amount) as amount'))
            ->join('tbl_custom_fee_assignment', 'tbl_custom_fee_assignment.id', '=', 'tbl_custom_fee_assign_heading.id_custom_fee_assign')
            ->where('tbl_custom_fee_assignment.id_student', $data['id_student'])
            ->where('tbl_custom_fee_assignment.id_institution_standard', $data['id_institution_standard'])
            ->where('tbl_custom_fee_assignment.id_fee_category', $data['id_fee_category'])
            ->where('tbl_custom_fee_assignment.id_institute', $data['id_institute'])
            ->where('tbl_custom_fee_assignment.id_academic_year', $data['id_academic_year'])->first();

            return $headingData;
        }
    }
?>