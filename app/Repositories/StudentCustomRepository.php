<?php 
    namespace App\Repositories;
    use App\Models\StudentCustom;
    use App\Interfaces\StudentCustomRepositoryInterface;
    use Storage;
    use League\Flysystem\Filesystem;

    class StudentCustomRepository implements StudentCustomRepositoryInterface
    {
        public function all(){
            return StudentCustom::all();            
        }

        public function store($data){
            return StudentCustom::create($data);
        }        

        public function fetch($idStudent)
        {
            return StudentCustom::where('id_student', $idStudent)->get();
        }  

        public function fetchExistingData($idStudent, $idCustomField){
            return StudentCustom::where('id_student', $idStudent)->where('id_custom_field', $idCustomField)->first();
        }
 
        public function update($data){
            return $data->save();
        }     

        public function updateCustomValues($data, $idStudent, $idCustomField){
            return StudentCustom::where('id_student', $idStudent)->where('id_custom_field', $idCustomField)->update($data);
        }



        public function delete($id){   
            return StudentCustom::find($id)->delete();
        }
        
        // File upload function
        public function upload($file)
        { 
            $path = Storage::disk('s3')->put('egenius_multitenant-s3/student/test', $file);
            $filePath = Storage::disk('s3')->url($path);
            return $filePath;
        }
    }  
?>