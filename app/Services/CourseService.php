<?php 
    namespace App\Services;
    use App\Models\Course;
    use App\Services\CourseService;
    use App\Repositories\CourseRepository;
    use App\Repositories\InstitutionTypeRepository;
    use Carbon\Carbon;
    use Session;

    class CourseService 
    {
        
        public function getAll()
        {
            $courseRepository = new CourseRepository();
            $nstitutionTypeRepository = new InstitutionTypeRepository();

            $course = $courseRepository->all();
            foreach($course as $index=>$details)
            {
                $institutionType = $institutionTypeRepository->fetch($details['id']);
                $data[$index] = $details;
                $data[$index]['institution_type_name'] = $institutionType->type_name;
            }
            return $data;
        }

        public function find($id){
            $courseRepository = new CourseRepository();
            
            $course = $courseRepository->fetch($id);

           
            return $course;
        }

        public function add($courseData)
        {
            $courseRepository = new CourseRepository();

            $check = Course::where('name', $courseData->course)->where('id_institution_type_mapping', $courseData->id_institution_type)->first();
            if(!$check){
              
                $data = array(
                    'id_institution_type_mapping' => $courseData->id_institution_type, 
                    'name' => $courseData->course, 
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );
                $storeData = $courseRepository->store($data); 
                
                if($storeData) {

                    $signal = 'success';
                    $msg = 'Data inserted successfully!';

                }else{

                    $signal = 'failure';
                    $msg = 'Error inserting data!';

                } 

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            } 
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;

        }

        public function update($courseData, $id){
            
            $courseRepository = new CourseRepository();
            
            $check = Course::where('name', $courseData->course)->where('id', '!=', $id)->first();
            if(!$check){

                $data = array(
                    'name' => $courseData->course, 
                    'modified_by' => Session::get('userId'),
                    'updated_at' => Carbon::now()
                );

                $storeData = $courseRepository->update($data, $id); 
              
                if($storeData) {

                    $signal = 'success';
                    $msg = 'Data updated successfully!';

                }else{

                    $signal = 'failure';
                    $msg = 'Error updating data!';

                } 

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            } 
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function delete($id){
            
            $courseRepository = new CourseRepository();
            
            $course = $courseRepository->delete($id);

            if($course){
                $signal = 'success';
                $msg = 'Course deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }

?>