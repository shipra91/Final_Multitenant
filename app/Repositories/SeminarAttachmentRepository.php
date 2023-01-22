<?php
    namespace App\Repositories;

    use App\Models\SeminarAttachment;
    use App\Interfaces\SeminarAttachmentRepositoryInterface;

    class SeminarAttachmentRepository implements SeminarAttachmentRepositoryInterface {

        public function all(){
            return SeminarAttachment::all();
        }

        public function store($data){
            return $data = SeminarAttachment::create($data);
        }

        public function fetch($idSeminar){
            return $data = SeminarAttachment::where('id_seminar', $idSeminar)->get();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($idSeminar){
            return $seminarAttachment = SeminarAttachment::where('id_seminar', $idSeminar)->delete();
        }
    }
