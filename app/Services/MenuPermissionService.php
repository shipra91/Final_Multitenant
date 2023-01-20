<?php
    namespace App\Services;

    use App\Models\MenuPermission;
    use App\Repositories\MenuPermissionRepository;
    use App\Repositories\RoleRepository;
    use App\Repositories\ModuleRepository;
    use App\Repositories\InstitutionModuleRepository;
    use Carbon\Carbon;
    use Session;
    use DB;

    class MenuPermissionService {

        public function getAll(){

            $moduleRepository = new ModuleRepository();
            $institutionModuleRepository = new InstitutionModuleRepository();
            $roleRepository = new RoleRepository();
            $menuPermissionRepository = new MenuPermissionRepository();
            $data = array();
            $arrayPermission = array();

            $permittedRoles = $menuPermissionRepository->permissionedRoles();

            foreach($permittedRoles as $index => $role){

                $modules = "";
                $permissions = $menuPermissionRepository->roleModules($role['id_role']);
                $roleData = $roleRepository->fetch($role['id_role']);

                foreach($permissions as $permission){

                    if($permission->view == 'NO' && $permission->view_own == 'NO' && $permission->create == 'NO' && $permission->edit == 'NO' && $permission->delete == 'NO' && $permission->export == 'NO' && $permission->import == 'NO'){

                    }else{

                        $moduleDetail = $institutionModuleRepository->fetch($permission->id_module);

                        if($moduleDetail){
                            $modules .= $moduleDetail->display_name.', ';
                        }
                    }
                }

                $modules = substr($modules, 0, -2);

                $data = array(
                    'id' => $role['id_role'],
                    'role' => $roleData->display_name,
                    'module' => $modules
                );
                array_push($arrayPermission, $data);
            }

            return $arrayPermission;
        }

        public function getAllServicePermission(){

            $moduleRepository = new ModuleRepository();
            $roleRepository = new RoleRepository();
            $menuPermissionRepository = new MenuPermissionRepository();
            $userType = 'service';
            $data = array();
            $arrayPermission = array();
            $roleId = $roleRepository->getRoleID($userType);

            $permissions = $menuPermissionRepository->getAllServicePermission($roleId->id);

            if($permissions){

                foreach($permissions as $permission){

                    $module = $moduleRepository->fetch($permission->id_module);
                    $role = $roleRepository->fetch($permission->id_role);

                    $data = array(
                        'id' => $permission->id,
                        'role' => $role->display_name,
                        'module' => $module->display_name,
                        'deleted_at' => $permission->deleted_at
                    );
                    array_push($arrayPermission, $data);
                }
            }

            return $arrayPermission;
        }

        public function getDeletedRecords(){

            $moduleRepository = new ModuleRepository();
            $roleRepository = new RoleRepository();
            $menuPermissionRepository = new MenuPermissionRepository();
            $institutionModuleRepository = new InstitutionModuleRepository();

            $data = array();
            $arrayPermission = array();
            $permissions = $menuPermissionRepository->allDeleted();
            // dd($permissions);
            foreach($permissions as $permission){

                $module = $institutionModuleRepository->fetch($permission->id_module);

                if($module){

                    $role = $roleRepository->fetch($permission->id_role);

                    $data = array(
                        'id' => $permission->id,
                        'role' => $role->display_name,
                        'module' => $module->display_name,
                        'deleted_at' => $permission->deleted_at
                    );
                    array_push($arrayPermission, $data);
                }
            }

            return $arrayPermission;
        }

        public function find($id){

            $menuPermissionRepository = new MenuPermissionRepository();

            $module = $menuPermissionRepository->fetch($id);
            return $module;
        }

        public function add($menuPermissionData){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $allActions = ['view', 'viewOwn', 'create', 'edit', 'delete', 'export', 'import'];

            $menuPermissionRepository = new MenuPermissionRepository();
            $count = 0;

            foreach($menuPermissionData->module as $index => $moduleId){

                $view = $viewOwn = $create = $edit = $delete = $export = $import = 'NO';

                foreach($allActions as $action){

                    if(isset($menuPermissionData->action[$moduleId])){

                        if($action == 'view' && in_array('view', $menuPermissionData->action[$moduleId])){
                            $view = 'YES';
                        }

                        if($action == 'viewOwn' && in_array('viewOwn', $menuPermissionData->action[$moduleId])){
                            $viewOwn = 'YES';
                        }

                        if($action == 'create' && in_array('create', $menuPermissionData->action[$moduleId])){
                            $create = 'YES';
                        }

                        if($action == 'edit' && in_array('edit', $menuPermissionData->action[$moduleId])){
                            $edit = 'YES';
                        }

                        if($action == 'delete' && in_array('delete', $menuPermissionData->action[$moduleId])){
                            $delete = 'YES';
                        }

                        if($action == 'export' && in_array('export', $menuPermissionData->action[$moduleId])){
                            $export = 'YES';
                        }

                        if($action == 'import' && in_array('import', $menuPermissionData->action[$moduleId])){
                            $import = 'YES';
                        }
                    }
                }

                $check = MenuPermission::where('id_institute', $institutionId)->where('id_academic', $academicId)->where('id_role', $menuPermissionData->role_name)->where('id_module', $moduleId)->first();

                if(!$check){

                    $data = array(
                        'id_institute' => $institutionId,
                        'id_academic' => $academicId,
                        'id_role' => $menuPermissionData->role_name,
                        'id_module' => $moduleId,
                        'view' => $view,
                        'view_own' => $viewOwn,
                        'create' => $create,
                        'edit' => $edit,
                        'delete' => $delete,
                        'export' => $export,
                        'import' => $import,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                    );

                    $storeData = $menuPermissionRepository->store($data);

                }else{

                    $idMenuPermission = $check->id;
                    $menuPermissionDetails = $menuPermissionRepository->fetch($idMenuPermission);

                    $menuPermissionDetails->view = $view;
                    $menuPermissionDetails->view_own = $viewOwn;
                    $menuPermissionDetails->edit = $edit;
                    $menuPermissionDetails->create = $create;
                    $menuPermissionDetails->delete = $delete;
                    $menuPermissionDetails->export = $export;
                    $menuPermissionDetails->import = $import;
                    $menuPermissionDetails->modified_by = Session::get('userId');
                    $menuPermissionDetails->updated_at = Carbon::now();

                    // dd($menuPermissionDetails);
                    $storeData = $menuPermissionRepository->update($menuPermissionDetails);

                    if($view == 'NO' && $viewOwn == 'NO' && $edit == 'NO' && $create == 'NO' && $delete == 'NO' && $export == 'NO' && $import == 'NO'){

                        // $deleteRoleMenuPermission = $menuPermissionRepository->deleteMenuPermission($idMenuPermission);
                    }
                }
            }

            if($storeData){

                $signal = 'success';
                $msg = 'Data inserted successfully!';

            }else{

                $signal = 'failure';
                $msg = 'Error inserting data!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function delete($idRole){

            $menuPermissionRepository = new MenuPermissionRepository();
            $module = $menuPermissionRepository->delete($idRole);

            if($module){
                $signal = 'success';
                $msg = 'Module Permission deleted successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error inserting data!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function getRolesModulesData(){

            DB::enableQueryLog();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $modules = array();

            $institutionModuleRepository = new InstitutionModuleRepository();
            $roleRepository = new RoleRepository();
            $moduleRepository = new ModuleRepository();

            $allParentModules = $institutionModuleRepository->all($institutionId);
            $roles = $roleRepository->institutionRoleMenuPermission();
            // dd($roles);

            foreach($allParentModules as $index => $module){
                // dd($module->id);
                $modules[$index]["id"] = $module->id_institution_module;
                $modules[$index]["module_label"] = $module->module_label;
                $modules[$index]["display_name"] = $module->display_name;
                $modules[$index]["id_parent"] = $module->id_parent;
                $modules[$index]["file_path"] = $module->file_path;
                $modules[$index]["icon"] = $module->icon;
                $modules[$index]["type"] = $module->type;
                $modules[$index]["is_custom_field_required"] = $module->is_custom_field_required;
                $modules[$index]["is_sms_mapped"] = $module->is_sms_mapped;
                $modules[$index]["is_email_mapped"] = $module->is_email_mapped;
                $modules[$index]["access_for"] = $module->access_for;
                $modules[$index]['sub_modules'] = array();

                $allChilds = $institutionModuleRepository->allSubModules($module->id);

                if(count($allChilds) > 0){

                    foreach($allChilds as $key => $child){

                        $modules[$index]['sub_modules'][$key]["id"] = $child->id_institution_module;
                        $modules[$index]['sub_modules'][$key]["module_label"] = $child->module_label;
                        $modules[$index]['sub_modules'][$key]["display_name"] = $child->display_name;
                        $modules[$index]['sub_modules'][$key]["id_parent"] = $child->id_parent;
                        $modules[$index]['sub_modules'][$key]["file_path"] = $child->file_path;
                        $modules[$index]['sub_modules'][$key]["icon"] = $child->icon;
                        $modules[$index]['sub_modules'][$key]["type"] = $child->type;
                        $modules[$index]['sub_modules'][$key]["is_custom_field_required"] = $child->is_custom_field_required;
                        $modules[$index]['sub_modules'][$key]["is_sms_mapped"] = $child->is_sms_mapped;
                        $modules[$index]['sub_modules'][$key]["is_email_mapped"] = $child->is_email_mapped;
                        $modules[$index]['sub_modules'][$key]["access_for"] = $child->access_for;
                    }
                }
            }

            $output = array(
                'modules' => $modules,
                'roles' => $roles
            );

            return $output;
        }

        public function getServiceRoleModulesData(){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];

            $institutionModuleRepository = new InstitutionModuleRepository();
            $roleRepository = new RoleRepository();
            $menuPermissionRepository = new MenuPermissionRepository();

            $idParent = '0';
            $allParentModules = $institutionModuleRepository->all($institutionId);
            $roles = $roleRepository->getRoleDetail('service');
            $modules = array();

            foreach($allParentModules as $index => $module){

                $modules[$index]["id"] = $module->id_institution_module;
                $modules[$index]["module_label"] = $module->module_label;
                $modules[$index]["display_name"] = $module->display_name;
                $modules[$index]["id_parent"] = $module->id_parent;
                $modules[$index]["file_path"] = $module->file_path;
                $modules[$index]["icon"] = $module->icon;
                $modules[$index]["type"] = $module->type;
                $modules[$index]["is_custom_field_required"] = $module->is_custom_field_required;
                $modules[$index]["is_sms_mapped"] = $module->is_sms_mapped;
                $modules[$index]["is_email_mapped"] = $module->is_email_mapped;
                $modules[$index]["access_for"] = $module->access_for;
                $modules[$index]['sub_modules'] = array();

                $allChilds = $institutionModuleRepository->allSubModules($module->id);

                if($allChilds){

                    foreach($allChilds as $key => $child){

                        $modules[$index]['sub_modules'][$key]["id"] = $child->id_institution_module;
                        $modules[$index]['sub_modules'][$key]["module_label"] = $child->module_label;
                        $modules[$index]['sub_modules'][$key]["display_name"] = $child->display_name;
                        $modules[$index]['sub_modules'][$key]["id_parent"] = $child->id_parent;
                        $modules[$index]['sub_modules'][$key]["file_path"] = $child->file_path;
                        $modules[$index]['sub_modules'][$key]["icon"] = $child->icon;
                        $modules[$index]['sub_modules'][$key]["type"] = $child->type;
                        $modules[$index]['sub_modules'][$key]["is_custom_field_required"] = $child->is_custom_field_required;
                        $modules[$index]['sub_modules'][$key]["is_sms_mapped"] = $child->is_sms_mapped;
                        $modules[$index]['sub_modules'][$key]["is_email_mapped"] = $child->is_email_mapped;
                        $modules[$index]['sub_modules'][$key]["access_for"] = $child->access_for;
                        // dd($permission);
                        $permission = $menuPermissionRepository->roleModulesPermission($idRole, $child->id_institution_module);

                        if($permission){

                            $permissionArray['view'] = $permission->view;
                            $permissionArray['view_own'] = $permission->view_own;
                            $permissionArray['edit'] = $permission->edit;
                            $permissionArray['create'] = $permission->create;
                            $permissionArray['delete'] = $permission->delete;
                            $permissionArray['export'] = $permission->export;
                            $permissionArray['import'] = $permission->import;

                        }else{

                            $permissionArray['view'] = 'NO';
                            $permissionArray['view_own'] = 'NO';
                            $permissionArray['edit'] = 'NO';
                            $permissionArray['create'] = 'NO';
                            $permissionArray['delete'] = 'NO';
                            $permissionArray['export'] = 'NO';
                            $permissionArray['import'] = 'NO';
                        }

                        // dd($permission);
                        $modules[$index]['sub_modules'][$key]["permission"] = $permissionArray;

                    }

                }else{

                    $permission = $menuPermissionRepository->roleModulesPermission($idRole, $module->id_institution_module);

                    if($permission){

                        $permissionArray['view'] = $permission->view;
                        $permissionArray['view_own'] = $permission->view_own;
                        $permissionArray['edit'] = $permission->edit;
                        $permissionArray['create'] = $permission->create;
                        $permissionArray['delete'] = $permission->delete;
                        $permissionArray['export'] = $permission->export;
                        $permissionArray['import'] = $permission->import;

                    }else{

                        $permissionArray['view'] = 'NO';
                        $permissionArray['view_own'] = 'NO';
                        $permissionArray['edit'] = 'NO';
                        $permissionArray['create'] = 'NO';
                        $permissionArray['delete'] = 'NO';
                        $permissionArray['export'] = 'NO';
                        $permissionArray['import'] = 'NO';
                    }

                    $modules[$index]["permission"] = $permissionArray;
                }
            }

            $output = array(
                'modules' => $modules,
                'roles' => $roles
            );

            return $output;
        }

        public function restore($id){

            $menuPermissionRepository = new MenuPermissionRepository();
            $module = $menuPermissionRepository->restore($id);

            if($module){
                $signal = 'success';
                $msg = 'Module Permission restored successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function restoreAll(){

            $menuPermissionRepository = new MenuPermissionRepository();
            $module = $menuPermissionRepository->restoreAll();

            if($module){
                $signal = 'success';
                $msg = 'Module Permission restored successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function roleMenuPermission($idRole, $institutionId){

            $menuPermissionRepository = new MenuPermissionRepository();
            $institutionModuleRepository = new InstitutionModuleRepository();
            $moduleRepository = new ModuleRepository();
            $roleRepository = new RoleRepository();

            $roleData = $roleRepository->fetch($idRole);
            $output = array();

            $allParentModules = $institutionModuleRepository->all($institutionId);
            // dd($allParentModules);

            foreach($allParentModules as $index => $module){

                $modules[$index]["id"] = $module->id_institution_module;
                $modules[$index]["module_label"] = $module->module_label;
                $modules[$index]["display_name"] = $module->display_name;
                $modules[$index]["id_parent"] = $module->id_parent;
                $modules[$index]["file_path"] = $module->file_path;
                $modules[$index]["icon"] = $module->icon;
                $modules[$index]["type"] = $module->type;
                $modules[$index]["is_custom_field_required"] = $module->is_custom_field_required;
                $modules[$index]["is_sms_mapped"] = $module->is_sms_mapped;
                $modules[$index]["is_email_mapped"] = $module->is_email_mapped;
                $modules[$index]["access_for"] = $module->access_for;
                $modules[$index]['sub_modules'] = array();

                $allChilds = $institutionModuleRepository->allSubModules($module->id);
                // dd($allChilds);

                if(count($allChilds) > 0){

                    foreach($allChilds as $key => $child){

                        $modules[$index]['sub_modules'][$key]["id"] = $child->id_institution_module;
                        $modules[$index]['sub_modules'][$key]["module_label"] = $child->module_label;
                        $modules[$index]['sub_modules'][$key]["display_name"] = $child->display_name;
                        $modules[$index]['sub_modules'][$key]["id_parent"] = $child->id_parent;
                        $modules[$index]['sub_modules'][$key]["file_path"] = $child->file_path;
                        $modules[$index]['sub_modules'][$key]["icon"] = $child->icon;
                        $modules[$index]['sub_modules'][$key]["type"] = $child->type;
                        $modules[$index]['sub_modules'][$key]["is_custom_field_required"] = $child->is_custom_field_required;
                        $modules[$index]['sub_modules'][$key]["is_sms_mapped"] = $child->is_sms_mapped;
                        $modules[$index]['sub_modules'][$key]["is_email_mapped"] = $child->is_email_mapped;
                        $modules[$index]['sub_modules'][$key]["access_for"] = $child->access_for;

                        $permission = $menuPermissionRepository->roleModulesPermission($idRole, $child->id_institution_module);

                        if($permission){

                            $permissionArray['view'] = $permission->view;
                            $permissionArray['view_own'] = $permission->view_own;
                            $permissionArray['edit'] = $permission->edit;
                            $permissionArray['create'] = $permission->create;
                            $permissionArray['delete'] = $permission->delete;
                            $permissionArray['export'] = $permission->export;
                            $permissionArray['import'] = $permission->import;

                        }else{

                            $permissionArray['view'] = 'NO';
                            $permissionArray['view_own'] = 'NO';
                            $permissionArray['edit'] = 'NO';
                            $permissionArray['create'] = 'NO';
                            $permissionArray['delete'] = 'NO';
                            $permissionArray['export'] = 'NO';
                            $permissionArray['import'] = 'NO';
                        }
                        // dd($permission);
                        $modules[$index]['sub_modules'][$key]["permission"] = $permissionArray;
                    }

                }else{

                    $permission = $menuPermissionRepository->roleModulesPermission($idRole, $module->id_institution_module);
                    // dd($permission);

                    if($permission){

                        $permissionArray['view'] = $permission->view;
                        $permissionArray['view_own'] = $permission->view_own;
                        $permissionArray['edit'] = $permission->edit;
                        $permissionArray['create'] = $permission->create;
                        $permissionArray['delete'] = $permission->delete;
                        $permissionArray['export'] = $permission->export;
                        $permissionArray['import'] = $permission->import;

                    }else{

                        $permissionArray['view'] = 'NO';
                        $permissionArray['view_own'] = 'NO';
                        $permissionArray['edit'] = 'NO';
                        $permissionArray['create'] = 'NO';
                        $permissionArray['delete'] = 'NO';
                        $permissionArray['export'] = 'NO';
                        $permissionArray['import'] = 'NO';
                    }
                    $modules[$index]["permission"] = $permissionArray;
                }
            }

            $output = array(
                'modules' => $modules,
                'roleData' => $roleData
            );

            return $output;
        }
    }

