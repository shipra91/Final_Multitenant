<?php
    namespace App\Repositories;
    use App\Models\Document;
    use App\Interfaces\DocumentRepositoryInterface;
    use Session;

    class DocumentRepository implements DocumentRepositoryInterface{

        public function all($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return Document::where('id_institute', $institutionId)->where('id_academic', $academicYear)->get();
        }

        public function store($data){
            return Document::create($data);
        }

        public function fetch($id){
            return Document::find($id);
        }

        // public function update($data, $id){
        //     return Document::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return Document::find($id)->delete();
        }
    }
?>
