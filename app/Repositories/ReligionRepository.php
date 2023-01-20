<?php
    namespace App\Repositories;
    use App\Models\Religion;
    use App\Interfaces\ReligionRepositoryInterface;

    class ReligionRepository implements ReligionRepositoryInterface{

        public function all(){
            return Religion::all();
        }

        public function store($data){
            return Religion::create($data);
        }

        public function fetch($id){
            return Religion::find($id);
        }

        // public function update($data, $id){
        //     return Religion::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return Religion::find($id)->delete();
        }

        public function fetchReligionId($religion){
            return Religion::where("name", $religion)->first();
        }
    }
?>
