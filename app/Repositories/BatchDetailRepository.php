<?php
    namespace App\Repositories;
    use App\Models\BatchDetail;
    use App\Interfaces\BatchDetailRepositoryInterface;

    class BatchDetailRepository implements BatchDetailRepositoryInterface {

        public function all($idBatch){
            return BatchDetail::where('id_batch', $idBatch)->get();
        }

        public function store($data){
            return $data = BatchDetail::create($data);
        }

        public function fetch($id){
            return $data = BatchDetail::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($ids){
            return $data = BatchDetail::whereIn('id', $ids)->delete();
        }
    }
?>
