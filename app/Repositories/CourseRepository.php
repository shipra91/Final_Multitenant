<?php 
    namespace App\Repositories;
    use App\Models\Course;
    use App\Interfaces\CourseRepositoryInterface;

    class CourseRepository implements CourseRepositoryInterface{

        public function all(){
            return Course::all();            
        }

        public function store($data){
            return Course::create($data);
        }        

        public function fetch($id){
            return Course::find($id);
        }        

        public function update($data, $id){
            return Course::whereId($id)->update($data);
        }        

        public function delete($id){
            return Course::find($id)->delete();
        }  

        public function getCourseId($course){
            return Course::where('name',$course)->first();
        }    

    }
?>