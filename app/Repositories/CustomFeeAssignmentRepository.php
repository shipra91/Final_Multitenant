<?php 
    namespace App\Repositories;
    use App\Models\CustomFeeAssignment;
    use App\Interfaces\CustomFeeAssignmentRepositoryInterface;
    use Session;
    use DB;

    class CustomFeeAssignmentRepository implements CustomFeeAssignmentRepositoryInterface{

        public function all(){
            return CustomFeeAssignment::all();            
        }

        public function store($data){
            return CustomFeeAssignment::create($data);
        }        

        public function fetch($idStudent, $idStandard, $idFeeCategory, $institutionId, $academicId){

            DB::enableQueryLog();
            $response = CustomFeeAssignment::join('tbl_custom_fee_assign_heading', 'tbl_custom_fee_assign_heading.id_custom_fee_assign', '=', 'tbl_custom_fee_assignment.id')
            ->join('tbl_custom_fee_assign_heading_installment', 'tbl_custom_fee_assign_heading.id', '=', 'tbl_custom_fee_assign_heading_installment.id_custom_fee_assign_heading')
            ->where('id_institute', $institutionId)
            ->where('id_academic_year', $academicId)
            ->where('id_fee_category', $idFeeCategory)
            ->where('id_institution_standard', $idStandard)
            ->where('id_student', $idStudent)
            ->get(['tbl_custom_fee_assign_heading.id_heading', 'tbl_custom_fee_assign_heading_installment.*']);
            // dd(DB::getQueryLog());
            // dd($response);
            return $response;
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id){
            return CustomFeeAssignment::find($id)->delete();
        }
    }
?>