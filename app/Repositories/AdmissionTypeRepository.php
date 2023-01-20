<?php
    namespace App\Repositories;
    use App\Models\AdmissionType;
    use App\Interfaces\AdmissionTypeRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;

    class AdmissionTypeRepository implements AdmissionTypeRepositoryInterface{

        public function all(){
            return AdmissionType::all();
        }

        public function store($data){
            return AdmissionType::create($data);
        }

        public function fetch($id){
            return AdmissionType::find($id);
        }

        // public function update($data, $id){
        //     return AdmissionType::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

         public function fetchType($type){
            return AdmissionType::where('type', $type)->first();
        }

        public function delete($id){
            return AdmissionType::find($id)->delete();
        }
    }
?>
