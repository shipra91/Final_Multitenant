<?php
    namespace App\Repositories;
    use App\Models\FeeType;
    use App\Interfaces\FeeTypeRepositoryInterface;

    class FeeTypeRepository implements FeeTypeRepositoryInterface{

        public function all(){
            return FeeType::all();
        }

        public function store($data){
            return FeeType::create($data);
        }

        public function fetch($id){
            return FeeType::find($id);
        }

        // public function update($data, $id){
        //     return FeeType::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return FeeType::find($id)->delete();
        }

        public function getStandardFeeType($standardId){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $feeType = FeeType::join('tbl_fee_master','tbl_fee_master.id_fee_type', '=', 'tbl_fee_type.id')
            ->where('id_institute', $institutionId)
            ->where('id_academic_year', $academicId)
            ->where('id_institution_standard', $standardId)
            ->groupBY("id_fee_type")
            ->get('tbl_fee_type.*');
            
            return $feeType;
        }
    }
?>
