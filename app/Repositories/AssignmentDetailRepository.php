<?php
    namespace App\Repositories;
    use App\Models\AssignmentDetail;
    use App\Interfaces\AssignmentDetailRepositoryInterface;

    class AssignmentDetailRepository implements AssignmentDetailRepositoryInterface{

        public function all(){
            return AssignmentDetail::all();
        }

        public function store($data){
            return $assignmentDetail = AssignmentDetail::create($data);
        }

        public function fetch($id){
            return $assignmentDetail = AssignmentDetail::where('id_assignment', $id)->get();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $data = AssignmentDetail::find($id)->delete();
        }
    }
