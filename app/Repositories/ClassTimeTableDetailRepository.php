<?php
    namespace App\Repositories;

    use App\Models\ClassTimeTableDetail;
    use App\Interfaces\ClassTimeTableDetailRepositoryInterface;
    use DB;

    class ClassTimeTableDetailRepository implements ClassTimeTableDetailRepositoryInterface{

        public function all(){
            return ClassTimeTableDetail::all();
        }

        public function store($data){
            return $classTimeTableDetail = ClassTimeTableDetail::create($data);
        }

        public function fetch($id){
            return $classTimeTableDetail = ClassTimeTableDetail::where('id_class_time_table', $id)->get();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($idClassTimeTable){
            // DB::enableQueryLog();
            $classTimeTableDetail = ClassTimeTableDetail::where('id_class_time_table', $idClassTimeTable)->delete();
            // dd(DB::getQueryLog());
            return $classTimeTableDetail;
        }
    }
