<?php
    namespace App\Repositories;

    use App\Models\WorkdoneAttachment;
    use App\Interfaces\WorkdoneAttachmentRepositoryInterface;

    class WorkdoneAttachmentRepository implements WorkdoneAttachmentRepositoryInterface {

        public function all(){
            return WorkdoneAttachment::all();
        }

        public function store($data){
            return $data = WorkdoneAttachment::create($data);
        }

        public function fetch($id){
            return $data = WorkdoneAttachment::where('id_workdone', $id)->get();
        }

        public function update($data){
            return $data->save();
        }

        // public function delete($id){
        //     return $data = WorkdoneAttachment::where('id_workdone', $id)->delete();
        // }

        public function delete($id){
            return $data = WorkdoneAttachment::find($id)->delete();
        }
    }
