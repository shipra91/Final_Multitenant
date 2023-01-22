<?php
    namespace App\Repositories;

    use App\Models\InstitutionModule;
    use App\Interfaces\InstitutionModuleRepositoryInterface;
    use DB;

    class InstitutionModuleRepository implements InstitutionModuleRepositoryInterface {

        public function all($institutionId){
            return InstitutionModule::join('tbl_module', 'tbl_module.id', '=', 'tbl_institution_modules.id_module')
                                    ->where('tbl_institution_modules.id_institution', $institutionId)
                                    ->where('tbl_institution_modules.id_parent', "0")
                                    ->orderBy('tbl_module.module_label', 'ASC')
                                    ->select('tbl_module.*', 'tbl_institution_modules.id as id_institution_module')
                                    ->get();
        }

        public function getInstitutionModules($idInstitute){
            return InstitutionModule::where('id_institution', $idInstitute)->get();
        }

        public function store($data){
            return InstitutionModule::create($data);
        }

        public function fetch($idModule){
            return InstitutionModule::join('tbl_module', 'tbl_module.id', '=', 'tbl_institution_modules.id_module')
                                    ->where('tbl_institution_modules.id', $idModule)
                                    ->select('tbl_module.*', 'tbl_institution_modules.id as id_institution_module')
                                    ->first();
        }

        public function fetchData($idModule, $idInstitute){
            return InstitutionModule::where('id_institution', $idInstitute)->where('id_module', $idModule)->withTrashed()->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return InstitutionModule::find($id)->delete();
        }

        public function deleteInstituteData($idModule, $idInstitute){
            return InstitutionModule::where('id_institution', $idInstitute)->where('id_module', $idModule)->delete();
        }

        public function getAllModuleId($institutionId, $moduleId){
            return InstitutionModule::withTrashed()->where('id_institution', $institutionId)->where('id_module', $moduleId)->first();
        }

        public function getModuleId($institutionId, $moduleId){
            return InstitutionModule::where('id_institution', $institutionId)->where('id_module', $moduleId)->first();
        }

        public function restore($id){
            return InstitutionModule::withTrashed()->find($id)->restore();
        }

        public function allSubModules($idParent, $allSessions){
            // dd($idParent);
            DB::enableQueryLog();
            
            $institutionId = $allSessions['institutionId'];

            $institutionSubModules = InstitutionModule::join('tbl_module', 'tbl_module.id', '=', 'tbl_institution_modules.id_module')->where('tbl_institution_modules.id_institution', $institutionId)
                                                ->where('tbl_institution_modules.id_parent', $idParent)
                                                ->select('tbl_module.*', 'tbl_institution_modules.id as id_institution_module')
                                                ->orderBy('tbl_module.module_label', 'ASC')
                                                ->get();
            return $institutionSubModules;
        }
    }

