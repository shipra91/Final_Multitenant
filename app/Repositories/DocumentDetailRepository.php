<?php
    namespace App\Repositories;
    use App\Models\DocumentDetail;
    use App\Interfaces\DocumentDetailRepositoryInterface;

    class DocumentDetailRepository implements DocumentDetailRepositoryInterface{

        public function all($idDocument){
            return DocumentDetail::where('id_document', $idDocument)->get();
        }

        public function store($data){
            return DocumentDetail::create($data);
        }

        public function fetch($id){
            return DocumentDetail::find($id);
        }

        // public function update($data, $id){
        //     return DocumentDetail::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return DocumentDetail::find($id)->delete();
        }
    }
?>
