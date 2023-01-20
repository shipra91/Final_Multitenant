<?php 
    namespace App\Repositories;
    use App\Models\DynamicTokens;
    use App\Interfaces\DynamicTokensRepositoryInterface;
    use App\Interfaces\ModuleDynamicTokensMappingRepositoryInterface;

    class DynamicTokensRepository implements DynamicTokensRepositoryInterface{

        public function all(){
            return DynamicTokens::all();            
        }

        public function getAllTokens($modules){
            
            return $allTokens = DynamicTokens::where("module", $modules)->get(); 
        }

        public function allDeleted(){
            return DynamicTokens::onlyTrashed()->get();            
        }

        public function store($data){
            return DynamicTokens::create($data);
        }        

        public function fetch($id){
            return DynamicTokens::find($id);
        }        

        public function restore($id){
            return DynamicTokens::withTrashed()->find($id)->restore();
        } 
        
        public function restoreAll(){
            return DynamicTokens::onlyTrashed()->restore();
        }

        public function delete($id){
            return DynamicTokens::find($id)->delete();
        }
    }
?>