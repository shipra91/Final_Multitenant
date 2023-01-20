<?php 
    namespace App\Repositories;
    use App\Models\OrganizationManagement;
    use App\Interfaces\OrganizationManagementRepositoryInterface;

    class OrganizationManagementRepository implements OrganizationManagementRepositoryInterface{

        public function all(){
            return OrganizationManagement::all();            
        }

        public function store($data){
            return OrganizationManagement::create($data);
        }        

        public function fetch($id){
            return OrganizationManagement::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id){   
            return OrganizationManagement::find($id)->delete();
        }

        public function fetchOrganizationManagement($idOrganization){
            return OrganizationManagement::where('id_organization', $idOrganization)->get();
        }  

        public function updateOrganizationManagement($data){
            return $data->save();
        } 
    }
?>