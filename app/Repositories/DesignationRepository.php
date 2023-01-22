<?php
    namespace App\Repositories;
    use App\Models\Designation;
    use App\Interfaces\DesignationRepositoryInterface;

    class DesignationRepository implements DesignationRepositoryInterface{

        public function all(){
            return Designation::all();
        }

        public function store($data){
            return Designation::create($data);
        }

        public function fetch($id){
            return Designation::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return Designation::find($id)->delete();
        }

        public function fetchDesignation($term){
            return Designation::where("name", 'LIKE','%'.$term.'%')->get();
        }

        public function fetchDesignationId($designation){
            return Designation::where("name", $designation)->first();
        }
    }
?>
