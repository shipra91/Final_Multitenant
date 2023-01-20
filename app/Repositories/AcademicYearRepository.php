<?php
    namespace App\Repositories;
    use App\Models\AcademicYear;
    use App\Interfaces\AcademicYearRepositoryInterface;
    use DB;

    class AcademicYearRepository implements AcademicYearRepositoryInterface{

        public function all(){
            return AcademicYear::orderBy('name')->get();
        }

        public function store($data){
            return $academicYear = AcademicYear::create($data);
        }

        public function fetch($id){            
            $academicYear = AcademicYear::find($id);
            return $academicYear;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $academicYear = AcademicYear::find($id)->delete();
        }
    }