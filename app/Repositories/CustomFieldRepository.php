<?php 
    namespace App\Repositories;
    use App\Models\CustomField;
    use App\Interfaces\CustomFieldRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;

    class CustomFieldRepository implements CustomFieldRepositoryInterface{

        public function all(){
            return CustomField::all();            
        }

        public function store($data){
            return CustomField::create($data);
        }        

        public function fetch($id){
            return CustomField::find($id);
        }    

        public function fetchCustomField($institutionId, $moduleName){
            return CustomField::where('id_institution', $institutionId)->where('module', $moduleName)->get();
        }

        public function getCustomFieldValue($column_name, $Id, $idCustomField, $model){
            $allValue =  $model::where($column_name, $Id)->where('id_custom_field', $idCustomField)->first();
            return $allValue;
            
        }
        
        public function update($data, $id){
            return CustomField::whereId($id)->update($data);
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
            return CustomField::find($id)->delete();
        }
    }
?>