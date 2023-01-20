<?php
    namespace App\Repositories;

    use App\Models\BatchStudent;
    use App\Interfaces\BatchStudentRepositoryInterface;

    class BatchStudentRepository implements BatchStudentRepositoryInterface {

        public function all(){
            return BatchStudent::all();
        }

        public function store($data){
            return $data = BatchStudent::create($data);
        }

        public function fetch($id){
            return $data = BatchStudent::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $data = BatchStudent::where('id_batch_detail', $id)->delete();
        }

        // Get batch students
        public function getBatchStudent($idBatchDetail){
            return $data = BatchStudent::where('id_batch_detail', $idBatchDetail)->get();
        }
    }
?>
