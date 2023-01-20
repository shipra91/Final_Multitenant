<?php
    namespace App\Repositories;
    use App\Models\InstitutionBankDetails;
    use App\Interfaces\InstitutionBankDetailsRepositoryInterface;

    class InstitutionBankDetailsRepository implements InstitutionBankDetailsRepositoryInterface{

        public function all(){
            return InstitutionBankDetails::all();
        }

        public function store($data){
            return InstitutionBankDetails::create($data);
        }

        public function fetch($id){
            return InstitutionBankDetails::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return InstitutionBankDetails::find($id)->delete();
        }

        public function allDeleted(){
            return InstitutionBankDetails::onlyTrashed()->get();
        }

        public function restore($id){
            return InstitutionBankDetails::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return InstitutionBankDetails::onlyTrashed()->restore();
        }
    }
?>
