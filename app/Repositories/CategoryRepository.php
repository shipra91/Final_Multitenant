<?php 
    namespace App\Repositories;
    use App\Models\Category;
    use App\Interfaces\CategoryRepositoryInterface;

    class CategoryRepository implements CategoryRepositoryInterface{

        public function all(){
            return Category::all();            
        }

        public function store($data){
            return Category::create($data);
        }        

        public function fetch($id){
            return Category::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id){
            return Category::find($id)->delete();
        }

        public function getCasteCategoryId($name){
            return Category::where('name', $name)->first();
        }
    }
?>