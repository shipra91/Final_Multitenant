<?php
    namespace App\Repositories;
    use App\Models\RoleLabel;
    use App\Interfaces\RoleLabelRepositoryInterface;
    use Session;
    use DB;

    class RoleLabelRepository implements RoleLabelRepositoryInterface{

        public function all(){
            return RoleLabel::all();
        }

        public function store($data){
            return $result = RoleLabel::create($data);
        }

        public function fetch($id){
            return $result = RoleLabel::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $result = RoleLabel::find($id)->delete();
        }
    }
