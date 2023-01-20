<?php 
    namespace App\Repositories;
    use App\Models\CourseMaster;
    use App\Interfaces\CourseMasterRepositoryInterface;
    use DB;

    class CourseMasterRepository implements CourseMasterRepositoryInterface{

        public function getall(){
             return CourseMaster::all();  
        }
        public function all(){
            return CourseMaster::select('board_university')->groupBy('board_university')->get();
        }

        public function fetchInstitutionType($boardUniversity){
            return CourseMaster::where('board_university', $boardUniversity)->select('institution_type')->groupBy('institution_type')->get();
        }  

        public function fetchCourse($institutionType, $boardUniversity){
            return CourseMaster::where('board_university', $boardUniversity)->where('institution_type', $institutionType)->select('course')->groupBy('course')->get();
        }  

        public function fetchStream($institutionType, $boardUniversity, $course){
            
            return CourseMaster::where('board_university', $boardUniversity)->where('institution_type', $institutionType)->where('course', $course)->select('stream')->groupBy('stream')->get();
             
        }  

        public function fetchCombination($institutionType, $boardUniversity, $course, $stream){
            DB::enableQueryLog();
            return CourseMaster::where('board_university', $boardUniversity)->where('institution_type', $institutionType)->where('course', $course)->where('stream', $stream)->select('combination')->groupBy('combination')->get();
            //  dd(DB::getQueryLog());
        }  


        public function store($data){
            return CourseMaster::create($data);
        }        

        public function fetch($id){
            return CourseMaster::find($id);
        }        

        public function update($data, $id){
            return CourseMaster::whereId($id)->update($data);
        }        

        public function delete($id){            
            return CourseMaster::find($id)->delete();
        }

        public function fetchCourseDetails($boardUniversity){
            return CourseMaster::where('board_university', $boardUniversity)->select('course')->groupBy('course')->get();
        }  

        public function fetchStreamDetails($boardUniversity, $course){

            return CourseMaster::where('board_university', $boardUniversity)->where('course', $course)->select('stream')->groupBy('stream')->get();
        }  

        public function fetchCombinationDetails($boardUniversity, $course, $stream){
            return CourseMaster::where('board_university', $boardUniversity)->where('course', $course)->where('stream', $stream)->select('combination')->groupBy('combination')->get();
        }  
    }
?>