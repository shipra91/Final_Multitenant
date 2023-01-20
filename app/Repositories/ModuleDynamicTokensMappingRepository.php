<?php 
    namespace App\Repositories;
    use App\Models\ModuleDynamicTokensMapping;
    use App\Interfaces\ModuleDynamicTokensMappingRepositoryInterface;

    class ModuleDynamicTokensMappingRepository implements ModuleDynamicTokensMappingRepositoryInterface{

        public function all(){
            return ModuleDynamicTokensMapping::all();            
        }

        public function getAllMappedModules($module){
            
            return ModuleDynamicTokensMapping::where('module', $module)->first();            
        }

        public function allDeleted(){
            return ModuleDynamicTokensMapping::onlyTrashed()->get();            
        }

        public function store($data){
            return ModuleDynamicTokensMapping::create($data);
        }        

        public function fetch($id){
            return ModuleDynamicTokensMapping::find($id);
        }        

        public function restore($id){
            return ModuleDynamicTokensMapping::withTrashed()->find($id)->restore();
        } 
        
        public function restoreAll(){
            return ModuleDynamicTokensMapping::onlyTrashed()->restore();
        }

        public function delete($id){
            return ModuleDynamicTokensMapping::find($id)->delete();
        }
    }
?>