<?php
    namespace App\Repositories;
    use App\Models\StudentLeaveAttachment;
    use App\Interfaces\StudentLeaveAttachmentRepositoryInterface;

    class StudentLeaveAttachmentRepository implements StudentLeaveAttachmentRepositoryInterface{

        public function all(){
            return StudentLeaveAttachment::all();
        }

        public function store($data){
            return $data = StudentLeaveAttachment::create($data);
        }

        public function fetch($id){
            return $data = StudentLeaveAttachment::where('id_leave_application', $id)->get();
        }

        public function update($data){
            return $data->save();
        }

        // public function delete($id){
        //     return $eventAttachment = EventAttachment::find($id)->delete();
        // }

        public function delete($id){
            return $data = StudentLeaveAttachment::where('id_leave_application', $id)->delete();
        }
    }
?>
