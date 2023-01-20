<?php
    namespace App\Repositories;
    use App\Models\WorkdoneAttachment;
    use App\Interfaces\WorkdoneAttachmentRepositoryInterface;

    class WorkdoneAttachmentRepository implements WorkdoneAttachmentRepositoryInterface{

        public function all(){
            return WorkdoneAttachment::all();
        }

        public function store($data){
            return $workdoneAttachment = WorkdoneAttachment::create($data);
        }

        public function fetch($id){
            return $workdoneAttachment = WorkdoneAttachment::where('id_workdone', $id)->get();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $workdoneAttachment = WorkdoneAttachment::where('id_workdone', $id)->delete();
        }
    }