<?php 
    namespace App\Repositories;
    use App\Models\Module;
    use App\Interfaces\ModuleRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;
    use DB;

    class ModuleRepository implements ModuleRepositoryInterface{

        public function allModules(){
            DB::enableQueryLog();
            $allModules = Module::all();  
            // dd(DB::getQueryLog()); 
            return $allModules;      
        }

        public function all($idParent){
            DB::enableQueryLog();
            $allModules = Module::where('id_parent', $idParent)->get();  
            // dd(DB::getQueryLog()); 
            return $allModules;      
        }
        
        public function allInstitutionModules($idParent){
            
            DB::enableQueryLog();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $allModules = Module::where('id_parent', $idParent)->get();  
            // dd(DB::getQueryLog()); 
            return $allModules;      
        }

        public function allParents(){
            return Module::where('id_parent', '0')->get();            
        }

        public function store($data){
            return Module::create($data);
        }        

        public function fetch($id){
            return Module::find($id);
        }  
        
        public function fetchByLabel($label){
            return Module::where('module_label', $label)->first();
        }

        public function fetchModule($option){
            return Module::where('is_custom_field_required', $option)->get();
        }

        public function getSmsModule(){
            $modules = Module::where('is_sms_mapped', 'Yes')->get();
            return $modules;
        }

        public function update($data){
            return $data->save();
        }     

        //file upload function
        // public function upload($request){
            
        //     if($request->hasfile('image')){
                
        //         $file = $request->file('image');
                
        //         $name = time().$file->getClientOriginalName();
                
        //         $filePath = 'egenius_multitenant-s3/images/test/' . $name;
        //         \Storage::disk('s3')->put($filePath, file_get_contents($file));
        //         $path = Storage::disk('s3')->path($file);
        //         return $filePath;

        //     }else{
        //         return 'no file found';
        //     }

        // }  

        public function delete($id){
            return Module::find($id)->delete();
        }
    }
?>