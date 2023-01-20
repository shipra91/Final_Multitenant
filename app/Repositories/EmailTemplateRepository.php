<?php 
    namespace App\Repositories;
    use App\Models\EmailTemplate;
    use App\Interfaces\EmailTemplateRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;

    class EmailTemplateRepository implements EmailTemplateRepositoryInterface{

        public function all(){
            return EmailTemplate::all();            
        }

        public function store($data){
            return EmailTemplate::create($data);
        }        

        public function fetch($id){
            return EmailTemplate::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id){
            return EmailTemplate::find($id)->delete();
        }

        public function allDeleted(){
            return EmailTemplate::onlyTrashed()->get();            
        }        

        public function restore($id){
            return EmailTemplate::withTrashed()->find($id)->restore();
        } 
        
        public function restoreAll(){
            return EmailTemplate::onlyTrashed()->restore();
        }
    }
?>