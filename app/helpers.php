<?php

    use Illuminate\Support\Facades\DB; 

    class Helper{

    public static function showMenu() {
        DB::enableQueryLog();
        $role_id = session('roleId');
        // print_r($role_id);
        $institutionParentModules = json_decode(DB::table('tbl_module')
                ->select(DB::raw('tbl_module.*'), DB::raw('tbl_institution_modules.id as id_institution_module'))
                ->join('tbl_institution_modules', 'tbl_institution_modules.id_module', '=', 'tbl_module.id')
                ->where('tbl_institution_modules.id_parent', "0")
                ->where('id_institution', session('institutionId'))
                ->orderBy('tbl_module.module_label', 'ASC')            
                ->whereNull('tbl_institution_modules.deleted_at')          
                ->whereNull('tbl_module.deleted_at')
                ->get()->toJson(), true); 

        $menu = array();
        $childUrlArray = array();
        
        foreach ($institutionParentModules as $index => $parent) {
                
                $checkIfModuleHasChild = json_decode(DB::table('tbl_module')
                    ->select(DB::raw('tbl_module.*'))
                    ->join('tbl_institution_modules', 'tbl_institution_modules.id_module', '=', 'tbl_module.id')
                    ->where('tbl_institution_modules.id_parent', $parent['id'])    
                    ->whereNull('tbl_module.deleted_at')  
                    ->whereNull('tbl_institution_modules.deleted_at')
                    ->orderBy('tbl_module.module_label', 'ASC')   
                    ->get()->toJson(), true);
                // dd(DB::getQueryLog());
                
                if(count($checkIfModuleHasChild) == 0){

                    $checkRolePermission = json_decode(DB::table('tbl_menu_permissions')
                        ->select(DB::raw('tbl_menu_permissions.*'))
                        ->join('tbl_institution_modules', 'tbl_menu_permissions.id_module', '=', 'tbl_institution_modules.id')
                        ->where('tbl_institution_modules.id', $parent['id_institution_module'])
                        ->where('tbl_menu_permissions.id_role', $role_id) 
                        ->where('id_institution', session('institutionId'))
                        ->where('id_academic', session('academicYear'))
                        ->orderBy('tbl_institution_modules.display_order', 'ASC')            
                        ->whereNull('tbl_menu_permissions.deleted_at')  
                        ->whereNull('tbl_institution_modules.deleted_at')
                        ->where(function($q){
                            $q->where('tbl_menu_permissions.view', 'YES')
                                ->orWhere('tbl_menu_permissions.view_own', 'YES')  
                            ->orWhere('tbl_menu_permissions.create', 'YES')   
                            ->orWhere('tbl_menu_permissions.edit', 'YES')   
                            ->orWhere('tbl_menu_permissions.delete', 'YES')   
                            ->orWhere('tbl_menu_permissions.export', 'YES')   
                            ->orWhere('tbl_menu_permissions.import', 'YES');
                        })
                        ->get()->toJson(), true); 

                    if(count($checkRolePermission) > 0){

                        $menu[$index]['id']      =   $parent['id_institution_module'];
                        $menu[$index]['name']    =   $parent['display_name'];
                        $menu[$index]['label']    =   $parent['module_label'];
                        $menu[$index]['url']     =   $parent['file_path'];       
                        $menu[$index]['icon']     =   $parent['icon'];                        
                        $menu[$index]['pages']   =   array($parent['page']);
                        $menu[$index]['subMenu'] =   array();
                    }

                }else{
                    // dd('child');
                    $array_child_menu = json_decode(DB::table('tbl_module')
                        ->select(DB::raw('tbl_module.*'), DB::raw('tbl_menu_permissions.*'), DB::raw('tbl_institution_modules.id as id_institution_module'))
                        ->join('tbl_institution_modules', 'tbl_institution_modules.id_module', '=', 'tbl_module.id')
                        ->join('tbl_menu_permissions', 'tbl_menu_permissions.id_module', '=', 'tbl_institution_modules.id')
                        ->where('tbl_menu_permissions.id_role', $role_id) 
                        ->where('tbl_institution_modules.id_parent', $parent['id'])            
                        ->where('tbl_menu_permissions.id_institute', session('institutionId'))            
                        ->where('tbl_menu_permissions.id_academic', session('academicYear'))     
                        ->whereNull('tbl_menu_permissions.deleted_at')  
                        ->whereNull('tbl_institution_modules.deleted_at')  
                        ->where(function($q){
                            $q->where('tbl_menu_permissions.view', 'YES')
                                ->orWhere('tbl_menu_permissions.view_own', 'YES')  
                            ->orWhere('tbl_menu_permissions.create', 'YES')   
                            ->orWhere('tbl_menu_permissions.edit', 'YES')   
                            ->orWhere('tbl_menu_permissions.delete', 'YES')   
                            ->orWhere('tbl_menu_permissions.export', 'YES')   
                            ->orWhere('tbl_menu_permissions.import', 'YES');
                        })->get()->toJson(), true);
                    // dd(DB::getQueryLog());
                    // dd($array_child_menu);
                    if(count($array_child_menu) > 0){

                        $permissionCount = 0;
                        $subMenuPages = array();
                        $menu[$index]['subMenu'] = array();

                        foreach($array_child_menu as $key => $child){

                            $checkRolePermission = json_decode(DB::table('tbl_menu_permissions')
                                ->select(DB::raw('tbl_menu_permissions.*'))
                                ->join('tbl_institution_modules', 'tbl_menu_permissions.id_module', '=', 'tbl_institution_modules.id')
                                ->where('tbl_institution_modules.id', $child['id_institution_module'])
                                ->where('tbl_menu_permissions.id_role', $role_id) 
                                ->where('id_institution', session('institutionId'))
                                ->where('id_academic', session('academicYear'))
                                ->orderBy('tbl_institution_modules.display_order', 'ASC')          
                                ->whereNull('tbl_menu_permissions.deleted_at')  
                                ->whereNull('tbl_institution_modules.deleted_at') 
                                ->get()->toJson(), true);  

                            // dd(DB::getQueryLog());
                            if(count($checkRolePermission) > 0){

                                $permissionCount++;
                                
                                array_push($subMenuPages, $child['page']);

                                $menu[$index]['subMenu'][$key]['id']      =   $child['id_institution_module'];
                                $menu[$index]['subMenu'][$key]['name']    =   $child['display_name'];
                                $menu[$index]['subMenu'][$key]['label']   =   $child['module_label'];
                                $menu[$index]['subMenu'][$key]['url']     =   $child['file_path'];
                                $menu[$index]['subMenu'][$key]['icon']    =   $child['icon'];
                                $menu[$index]['subMenu'][$key]['page']    =   $child['page'];
                            }
                        }
                        if($permissionCount > 0){
                            $menu[$index]['id']      =   $parent['id_institution_module'];
                            $menu[$index]['name']    =   $parent['display_name'];
                            $menu[$index]['label']   =   $parent['module_label'];
                            $menu[$index]['url']     =   $parent['file_path'];
                            $menu[$index]['icon']    =   $parent['icon'];
                            $menu[$index]['pages']   =   $subMenuPages;
                        }
                        
                        
                    }
                }  
            } 

        // dd($menu);
        return $menu;

    }

    //CHECK ACCESS
    public static function checkAccess($moduleLabel, $action){
        
        $idRole = session('roleId');
        $idInstitution = session('institutionId');
        $idAcademic = session('academicYear');

        $query = DB::table('tbl_menu_permissions')
                ->join('tbl_institution_modules', 'tbl_menu_permissions.id_module', '=', 'tbl_institution_modules.id')
                ->join('tbl_module', 'tbl_institution_modules.id_module', '=', 'tbl_module.id')
                ->where('tbl_menu_permissions.id_role', $idRole)
                ->where('tbl_menu_permissions.id_institute', $idInstitution)
                ->where('tbl_menu_permissions.id_academic', $idAcademic)
                ->where('tbl_module.module_label', $moduleLabel)
                ->where("$action", 'YES')
                ->first();
        if($query){
            return true;
        }else{
            return false;
        }
    }

    public static function domainCheck(){

        // $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://" . $_SERVER['HTTP_HOST'];
        // $url = url()->current();
        // return $_SERVER['HTTP_HOST'];

        $query = [];

        $query = DB::table('tbl_institution')
                ->join('tbl_organization', 'tbl_institution.id_organization', '=', 'tbl_organization.id')
                ->where('tbl_institution.website_url', $_SERVER['HTTP_HOST'])
                ->whereNull('tbl_organization.deleted_at')
                ->whereNull('tbl_institution.deleted_at')
                ->select('tbl_organization.*', 'tbl_institution.id as institution_id', 'tbl_institution.name as institution_name', 'tbl_institution.institution_logo')
                ->first();
        if($query){
            return $query;
        }else{
            return "error";
        }
    }
    
    public static function domainCheckWithUrl($url){

        $query = DB::table('tbl_institution')
                ->join('tbl_organization', 'tbl_institution.id_organization', '=', 'tbl_organization.id')
                ->where('tbl_institution.website_url', $url)
                ->orWhere('tbl_organization.website_url', $url)
                ->whereNull('tbl_organization.deleted_at')
                ->whereNull('tbl_institution.deleted_at')
                ->select('tbl_organization.*', 'tbl_institution.id as institution_id', 'tbl_institution.name as institution_name', 'tbl_institution.institution_logo')
                ->first();

        return $query;
    }

    //FETCH ALL THE ACADEMIC YEARS FOR INSTITUTION
    public static function fetchAcademicYears(){
        DB::enableQueryLog();
        
        $idInstitution = session('institutionId');

        $allAcademicYears = json_decode(DB::table('tbl_academic_year_mappings')
                            ->join('tbl_academic_years', 'tbl_academic_years.id', '=', 'tbl_academic_year_mappings.id_academic_year')
                            ->where('tbl_academic_year_mappings.id_institute', $idInstitution)
                            ->select('tbl_academic_years.name', 'tbl_academic_year_mappings.id')
                            ->orderBY('tbl_academic_years.from_date')
                            ->get()->toJson(), true);
                            
        return $allAcademicYears;
    }

    //GET PAGE OF THE CURRENT SUB-MODULE
    public static function getSubModulePage($idSubModule){
        $institutionParentModules = DB::table('tbl_module')
                ->select(DB::raw('tbl_module.*'))
                ->join('tbl_institution_modules', 'tbl_institution_modules.id_module', '=', 'tbl_module.id')
                ->where('tbl_institution_modules.id', $idSubModule)
                ->where('id_institution', session('institutionId'))
                ->orderBy('tbl_institution_modules.display_order', 'ASC')            
                ->where('tbl_institution_modules.deleted_at', null)
                ->first(); 

        // dd($institutionParentModules);
        return $institutionParentModules;
    }
}
?>