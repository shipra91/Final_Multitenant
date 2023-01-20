<?php
    namespace App\Repositories;
    use App\Models\Nationality;
    use App\Interfaces\NationalityRepositoryInterface;

    class NationalityRepository implements NationalityRepositoryInterface{

        public function all(){
            return Nationality::all();
        }

        public function store($data){
            return Nationality::create($data);
        }

        public function fetch($id){
            return Nationality::find($id);
        }

        // public function update($data, $id){
        //     return Nationality::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return Nationality::find($id)->delete();
        }
    }
?>
