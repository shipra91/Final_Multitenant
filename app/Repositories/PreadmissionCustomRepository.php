<?php 
    namespace App\Repositories;
    use App\Models\PreadmissionCustom;
    use App\Interfaces\PreadmissionCustomRepositoryInterface;
    use Storage;
    use League\Flysystem\Filesystem;

    class PreadmissionCustomRepository implements PreadmissionCustomRepositoryInterface
    {
        public function all(){
            return PreadmissionCustom::all();            
        }

        public function store($data){
            return PreadmissionCustom::create($data);
        }        

        public function fetch($idPreadmission)
        {
            return PreadmissionCustom::where('id_Preadmission', $idPreadmission)->get();
        }  
 

        public function update($data, $id){
            return PreadmissionCustom::whereId($id)->update($data);
        }     

        public function updateCustomValues($data, $idPreadmission, $idCustomField){
            return PreadmissionCustom::where('id_Preadmission', $idPreadmission)->where('id_custom_field', $idCustomField)->update($data);
        }

        public function delete($id){   
            return PreadmissionCustom::find($id)->delete();
        }
        
        // File upload function
        public function upload($file)
        { 
            $path = Storage::disk('s3')->put('egenius_multitenant-s3/Preadmission/test', $file);
            $filePath = Storage::disk('s3')->url($path);
            return $filePath;
        }
    }  
?>