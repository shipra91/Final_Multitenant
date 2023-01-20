<?php 
    namespace App\Repositories;
    use App\Models\Role;
    use App\Interfaces\RoleRepositoryInterface;    

    class RoleRepository implements RoleRepositoryInterface{

        public function all(){
            $roles = Role::all();  
            return $roles;      
        }

        public function institutionRoles(){            
            $roles = Role::where('visibility', 'YES')->get();  
            return $roles;      
        }

        public function institutionRoleMenuPermission($allSessions){   
            
            $menuPermissionRepository = new MenuPermissionRepository();
            $roleArray = $rolePermissionArray = $rolesHavingNoPermissionArray = array();

            $roles = $this->institutionRoles();  
            foreach($roles as $role){
                array_push($roleArray, $role['id']);
            }

            $rolesPermissions = $menuPermissionRepository->permissionedRoles($allSessions);  
            foreach($rolesPermissions as $rolesPermission){
                array_push($rolePermissionArray, $rolesPermission['id_role']);
            }

            $rolesHavingNoPermissions = array_diff($roleArray, $rolePermissionArray);
            foreach($rolesHavingNoPermissions as $index => $rolesHavingNoPermission){
                $rolesHavingNoPermissionArray[$index] = $this->fetch($rolesHavingNoPermission);
            }
            return $rolesHavingNoPermissionArray;      
        }

        public function store($data){
            return Role::create($data);
        }  


        public function fetch($id){
            return Role::find($id);
        }        

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return Role::find($id)->delete();
        }

        public function getRoleID($userType = ''){
            return Role::where('label', $userType)->first();  
        }

        public function getRoleDetail($userType = ''){
            return Role::where('label', $userType)->get();  
        }
        
    }
?>