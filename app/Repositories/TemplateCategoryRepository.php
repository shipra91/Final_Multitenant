<?php 
    namespace App\Repositories;
    use App\Models\TemplateCategory;
    use App\Interfaces\TemplateCategoryRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;

    class TemplateCategoryRepository implements TemplateCategoryRepositoryInterface{

        public function all(){
            return TemplateCategory::all();
        }

        public function store($data){
            return TemplateCategory::create($data);
        }

        public function fetch($id){
            return TemplateCategory::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return TemplateCategory::find($id)->delete();
        }
    }
?>