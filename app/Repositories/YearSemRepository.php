<?php 
    namespace App\Repositories;
    use App\Models\YearSem;
    use App\Interfaces\YearSemRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;
    use Session;

    class YearSemRepository implements YearSemRepositoryInterface{

        public function all($idYear){
            $institutionId = Session::get('institutionId');
            $academicYear = Session::get('academicYear');
            return YearSem::where('id_year', $idYear)->where('id_institution', $institutionId)->where('id_academic_year', $academicYear)->orderBy('created_at', 'ASC')->get();     
        }

        public function store($data){
            return YearSem::create($data);
        }        

        public function fetch($id){
            return YearSem::find($id);
        }    

        public function fetchSem($idYear){
            $institutionId = Session::get('institutionId');
            $academicYear = Session::get('academicYear');
            return YearSem::where('id_year', $idYear)->where('id_institution', $institutionId)->where('id_academic_year', $academicYear)->get();
        }  

        public function update($data){
             return $data->save();
        } 

        public function delete($id){
            return YearSem::find($id)->delete();
        }

        public function getYearSemId($semName){
            return YearSem::where('sem_label', $semName)->first();
        }
    }
?>