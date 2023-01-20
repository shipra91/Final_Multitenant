<?php
    namespace App\Repositories;
    use App\Models\ProjectDetail;
    use App\Interfaces\ProjectDetailRepositoryInterface;

    class ProjectDetailRepository implements ProjectDetailRepositoryInterface{

        public function all(){
            return ProjectDetail::all();
        }

        public function store($data){
            return $projectDetail = ProjectDetail::create($data);
        }

        public function fetch($id){
            return $projectDetail = ProjectDetail::where('id_project', $id)->get();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $projectDetail = ProjectDetail::where('id_project', $id)->delete();
        }
    }