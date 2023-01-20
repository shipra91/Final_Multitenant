<?php
    namespace App\Repositories;

    use App\Models\ProjectDetail;
    use App\Interfaces\ProjectDetailRepositoryInterface;

    class ProjectDetailRepository implements ProjectDetailRepositoryInterface {

        public function all(){
            return ProjectDetail::all();
        }

        public function store($data){
            return $data = ProjectDetail::create($data);
        }

        public function fetch($id){
            return $data = ProjectDetail::where('id_project', $id)->get();
        }

        public function update($data){
            return $data->save();
        }

        // public function delete($id){
        //     return $data = ProjectDetail::where('id_project', $id)->delete();
        // }

        public function delete($id){
            return $data = ProjectDetail::find($id)->delete();
        }
    }
