<?php
    namespace App\Repositories;

    use App\Models\GradeDetail;
    use App\Interfaces\GradeDetailRepositoryInterface;
    use Session;

    class GradeDetailRepository implements GradeDetailRepositoryInterface {

        public function all($idGrade){
            return GradeDetail::where('id_grade', $idGrade)->get();
        }

        // public function all(){
        //     return GradeDetail::all();
        // }

        public function store($data){
            return GradeDetail::create($data);
        }

        public function fetch($id){
            return GradeDetail::find($id);
        }

        // public function update($data, $id){
        //     return DocumentDetail::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return GradeDetail::find($id)->delete();
        }
    }
