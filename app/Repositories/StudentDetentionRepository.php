<?php
    namespace App\Repositories;
    use App\Models\StudentDetention;
    use App\Interfaces\StudentDetentionRepositoryInterface;
    use DB;

    class StudentDetentionRepository implements StudentDetentionRepositoryInterface{

        public function all(){
            return StudentDetention::all();
        }

        public function store($data){
            return $studentDetention = StudentDetention::create($data);
        }

        public function fetch($idStudent){
            //\DB::enableQueryLog();
            $studentDetention = StudentDetention::where($id);
            // dd(\DB::getQueryLog());
            return $studentDetention;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $studentDetention = StudentDetention::find($id)->delete();
        }
    }
