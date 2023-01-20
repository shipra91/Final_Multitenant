<?php
    namespace App\Repositories;
    use App\Models\FeeCategory;
    use App\Interfaces\FeeCategoryRepositoryInterface;
    use DB;

    class FeeCategoryRepository implements FeeCategoryRepositoryInterface{

        public function all(){
            return FeeCategory::all();
        }

        public function store($data){
            return FeeCategory::create($data);
        }

        public function fetch($id){
           return FeeCategory::find($id);
        }

        // public function update($data, $id){
        //     return FeeCategory::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return FeeCategory::find($id)->delete();
        }
    }

