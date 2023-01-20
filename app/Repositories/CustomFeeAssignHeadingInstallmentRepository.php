<?php 
    namespace App\Repositories;
    use App\Models\CustomFeeAssignHeadingInstallment;
    use App\Interfaces\CustomFeeAssignHeadingInstallmentRepositoryInterface;

    class CustomFeeAssignHeadingInstallmentRepository implements CustomFeeAssignHeadingInstallmentRepositoryInterface{

        public function all(){
            return CustomFeeAssignHeadingInstallment::all();            
        }

        public function store($data){
            return CustomFeeAssignHeadingInstallment::create($data);
        }        

        public function fetch($id){
            return CustomFeeAssignHeadingInstallment::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id_custom_fee_assign_heading){
            return CustomFeeAssignHeadingInstallment::where('id_custom_fee_assign_heading', $id_custom_fee_assign_heading)->delete();
        }
    }
?>