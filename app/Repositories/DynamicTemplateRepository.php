<?php 
    namespace App\Repositories;
    use App\Models\DynamicTemplate;
    use App\Interfaces\DynamicTemplateRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;

    class DynamicTemplateRepository implements DynamicTemplateRepositoryInterface{

        public function all(){
            return DynamicTemplate::all();
        }

        public function allCertificate($type){
            return DynamicTemplate::where('template_category', $type)->get();
        }

        public function store($data){
            return DynamicTemplate::create($data);
        }

        public function fetch($id){
            return DynamicTemplate::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return DynamicTemplate::find($id)->delete();
        }
    }
?>