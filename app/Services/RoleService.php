<?php 
    namespace App\Services;
    use App\Models\Role;
    use App\Repositories\RoleRepository;
    use Session;

    class RoleService {
        public function getAll(){
            $roleRepository = new RoleRepository(); 
            $roles = $roleRepository->all();
            return $roles;
        }

        public function getRoleID($userType = ''){
            $roleRepository = new RoleRepository(); 
            $role = $roleRepository->getRoleID($userType);
            return $role;
        }

        public function find($id){
            $roleRepository = new RoleRepository(); 
            $role = $roleRepository->fetch($id);
            return $role;
        }

        public function add($roleData){
            $roleRepository = new RoleRepository(); 

            $allSessions = session()->all();
            
            $check = Role::where('label', $roleData->role_label)->first();
            
            if(!$check){
                
                $data = array(
                    'label' => $roleData->role_label, 
                    'display_name' => $roleData->display_name, 
                    'created_by' => $allSessions['emp_id']
                );
                $storeData = $roleRepository->store($data); 
                
                if($storeData) {

                    $signal = 'success';
                    $msg = 'Data inserted successfully!';

                }else{

                    $signal = 'failure';
                    $msg = 'Error inserting data!';

                } 

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            } 
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;

        }

        public function update($roleData, $id){

            $roleRepository = new RoleRepository(); 
            $allSessions = session()->all();
            
            $check = Role::where('label', $roleData->role_label)->where('display_name', $roleData->display_name)->where('id', '!=', $id)->first();
            if(!$check){

                $roleDetail = $roleRepository->fetch($id);
                
                $roleDetail->label = $roleData->role_label;
                $roleDetail->display_name = $roleData->display_name; 
                $roleDetail->modified_by = $allSessions['emp_id'];                
                // dd($roleData);
                $storeData = $roleRepository->update($roleDetail); 
                
                if($storeData) {

                    $signal = 'success';
                    $msg = 'Data updated successfully!';

                }else{

                    $signal = 'failure';
                    $msg = 'Error updating data!';

                } 

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            } 
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function delete($id){
            $roleRepository = new RoleRepository(); 
            $role = $roleRepository->delete($id);

            if($role){
                $signal = 'success';
                $msg = 'Role deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }

?>