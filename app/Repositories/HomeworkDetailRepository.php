<?php
    namespace App\Repositories;
    use App\Models\HomeworkDetail;
    use App\Interfaces\HomeworkDetailRepositoryInterface;

    class HomeworkDetailRepository implements HomeworkDetailRepositoryInterface{

        public function all(){
            return HomeworkDetail::all();
        }

        public function store($data){
            return $homeworkDetail = HomeworkDetail::create($data);
        }

        public function fetch($id){
            return $homeworkDetail = HomeworkDetail::where('id_homework', $id)->get();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $data = HomeworkDetail::find($id)->delete();
        }
    }
