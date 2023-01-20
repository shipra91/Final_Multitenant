<?php
    namespace App\Repositories;

    use App\Models\MenuPermission;
    use App\Interfaces\MenuPermissionRepositoryInterface;

    class MenuPermissionRepository implements MenuPermissionRepositoryInterface {

        public function all($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return MenuPermission::where('id_institute', $institutionId)
                                ->where('id_academic', $academicId)->get();
        }

        public function getAllServicePermission($roleId, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return MenuPermission::where('id_role', $roleId)->where('id_institute', $institutionId)
                                ->where('id_academic', $academicId)
                                ->get();
        }

        public function allDeleted($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return MenuPermission::onlyTrashed()
                ->where('id_institute', $institutionId)
              ->where('id_academic', $academicId)->get();
        }

        public function store($data){
            return MenuPermission::create($data);
        }

        public function update($data){
            return $data->save();
        }

        public function fetch($id){
            return MenuPermission::find($id);
        }

        public function restore($id){
            return MenuPermission::withTrashed()->find($id)->restore();
        }

        public function restoreAll($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return MenuPermission::onlyTrashed()->where('id_institute', $institutionId)
                                ->where('id_academic', $academicId)
                                ->restore();
        }

        public function delete($idRole){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return MenuPermission::where('id_institute', $institutionId)
                                    ->where('id_academic', $academicId)->where('id_role', $idRole)
                                    ->delete();
        }

        public function deleteRoleMenuPermission($roleId, $moduleId){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return MenuPermission::where('id_institute', $institutionId)
                                ->where('id_academic', $academicId)->where('id_role', $roleId)->where('id_module', $moduleId)->delete();
        }

        public function deleteMenuPermission($id){
            return MenuPermission::find($id)->delete();
        }

        public function permissionedRoles($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $roles = MenuPermission::join('tbl_role', 'tbl_menu_permissions.id_role', '=', 'tbl_role.id')->where('id_institute', $institutionId)
                                    ->where('id_academic', $academicId)
                                    ->select('tbl_menu_permissions.id_role')->groupBy('tbl_menu_permissions.id_role')->get();
            // dd($roles);
            return $roles;
        }

        public function roleModules($roleId, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $modules = MenuPermission::where('id_role', $roleId)->where('id_institute', $institutionId)
                                    ->where('id_academic', $academicId)->get();
            return $modules;
        }

        public function roleModulesPermission($roleId, $idModule, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $modules = MenuPermission::where('id_role', $roleId)
                                    ->where('id_module', $idModule)
                                    ->where('id_institute', $institutionId)
                                    ->where('id_academic', $academicId)
                                    ->first();
            // dd($idModule);
            return $modules;
        }
    }
