<?php
    namespace App\Repositories;
    use App\Models\Department;
    use App\Interfaces\DepartmentRepositoryInterface;

    class DepartmentRepository implements DepartmentRepositoryInterface{

        public function all(){
            return Department::all();
        }

        public function store($data){
            return Department::create($data);
        }

        public function fetch($id){
            return Department::find($id);
        }

        // public function update($data, $id){
        //     return Department::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return Department::find($id)->delete();
        }

        public function fetchDepartmentId($designation){
            return Department::where("name", $designation)->first();
        }
    }
?>
