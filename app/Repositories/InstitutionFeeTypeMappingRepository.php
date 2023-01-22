<?php
    namespace App\Repositories;

    use App\Models\InstitutionFeeTypeMapping;
    use App\Interfaces\InstitutionFeeTypeMappingRepositoryInterface;
    use DB;

    class InstitutionFeeTypeMappingRepository implements InstitutionFeeTypeMappingRepositoryInterface {

        public function all($allSessions){
            $institutionId = $allSessions['institutionId'];
            return InstitutionFeeTypeMapping::where('id_institute', $institutionId)->get();
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

        public function allDeleted($allSessions){
            return InstitutionFeeTypeMapping::where('id_institute', $institutionId)->onlyTrashed()->get();
        }

        public function restore($id){
            return InstitutionFeeTypeMapping::withTrashed()->find($id)->restore();
        }

        public function restoreAll($allSessions){
            return InstitutionFeeTypeMapping::where('id_institute', $institutionId)->onlyTrashed()->restore();
        }

        public function getInstitutionFeetype($allSessions){
            
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
