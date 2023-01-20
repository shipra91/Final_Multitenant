<?php
    namespace App\Repositories;

    use App\Models\InstitutionFeeTypeMapping;
    use App\Interfaces\InstitutionFeeTypeMappingRepositoryInterface;
    use DB;

    class InstitutionFeeTypeMappingRepository implements InstitutionFeeTypeMappingRepositoryInterface {

        public function all(){
            return InstitutionFeeTypeMapping::all();
        }

        public function store($data){
            return $institutionFeeTypeMapping = InstitutionFeeTypeMapping::create($data);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $institutionFeeTypeMapping = InstitutionFeeTypeMapping::find($id)->delete();
        }

        public function allDeleted(){
            return InstitutionFeeTypeMapping::onlyTrashed()->get();
        }

        public function restore($id){
            return InstitutionFeeTypeMapping::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return InstitutionFeeTypeMapping::onlyTrashed()->restore();
        }

        public function getInstitutionFeetype(){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];

            return InstitutionFeeTypeMapping::join('tbl_fee_type','tbl_fee_type.id', '=', 'tbl_institution_fee_type_mapping.id_fee_type')
                                            ->where('id_institute', $institutionId)
                                            ->select('tbl_fee_type.name','tbl_institution_fee_type_mapping.id')
                                            ->get();
        }

        public function fetch($idInstitutionFeetype){

            return InstitutionFeeTypeMapping::join('tbl_fee_type','tbl_fee_type.id', '=', 'tbl_institution_fee_type_mapping.id_fee_type')
                                            ->where('tbl_institution_fee_type_mapping.id', $idInstitutionFeetype)
                                            ->select('tbl_fee_type.name')
                                            ->first();
        }

        public function getInstitutionFeeTypeId($feeType){

            return InstitutionFeeTypeMapping::join('tbl_fee_type','tbl_fee_type.id', '=',    'tbl_institution_fee_type_mapping.id_fee_type')
                                            ->where('tbl_fee_type.name', $feeType)
                                            ->first();
        }

    }

    ?>
