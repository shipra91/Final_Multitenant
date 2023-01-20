<?php 
    namespace App\Services;
    use App\Models\CourseMaster;
    use App\Services\CourseMasterService;
    use App\Repositories\CourseMasterRepository;

    use App\Repositories\BoardRepository;
    use App\Repositories\InstitutionTypeRepository;
    use App\Repositories\CourseRepository;
    use App\Repositories\StreamRepository;
    use App\Repositories\CombinationRepository;
    use App\Repositories\InstitutionCourseMasterRepository;

    use App\Models\Board;
    use App\Models\InstitutionType;
    use App\Models\Course;
    use App\Models\Stream;
    use App\Models\Combination;

    use Carbon\Carbon;
    use Session;
    use DB;

    class CourseMasterService 
    {
        public function getAll()
        { 
            $boardRepository = new BoardRepository();
            $courseMasterRepository = new CourseMasterRepository();
            DB::enableQueryLog();
            $courseMasterDetails = [];
            $courseMaster = $courseMasterRepository->all();
                // dd($courseMaster);
           
            foreach($courseMaster as $key => $course)
            {
                $boardName='';
                $details =  $boardRepository->fetch($course['board_university']);
                $boardDetails['id'] = $course['board_university'];
                if($details){
                    $boardName = $details->name;      
                }
                $boardDetails['name'] =  $boardName;

                $courseMasterDetails[$key] = $boardDetails;
            }
            return $courseMasterDetails;
        }

        public function fetchAll()
        { 
            $combinationRepository = new CombinationRepository();
            $streamRepository = new StreamRepository();
            $courseRepository = new CourseRepository();
            $institutionTypeRepository = new InstitutionTypeRepository();
            $boardRepository = new BoardRepository();
            $courseMasterRepository = new CourseMasterRepository();
            DB::enableQueryLog();
            $courseMaster = $courseMasterRepository->getall();

            $courseMasterArray = array();

            foreach($courseMaster as $index => $details)
            {
                $combinationArray = array();
                $combinationIdArray = array();
                $boardUniversity = $boardRepository->fetch($details->board_university);
                $institutionType = $institutionTypeRepository->fetch($details->institution_type);
                $course = $courseRepository->fetch($details->course);
                $stream = $streamRepository->fetch($details->stream);
                $combinationIdArray[$index] = explode(',', $details->combination);
               
                foreach($combinationIdArray[$index] as $key => $combinationId)
                { 
                    $combination = $combinationRepository->fetch($combinationId);
                    $combinationArray[$index][$key] = $combination->name;
                }

                $combinations = '';
                $combinations = implode(',', $combinationArray[$index]);

                $courseMasterArray[$index]['courseMasterdId'] = $details->id;
                $courseMasterArray[$index]['board_university'] = $boardUniversity->name;
                $courseMasterArray[$index]['institution_type'] = $institutionType->type_name;
                $courseMasterArray[$index]['course'] = $course->name;
                $courseMasterArray[$index]['stream'] = $stream->name;
                $courseMasterArray[$index]['combination'] = $combinations;
            }
            return $courseMasterArray;
        }

        public function getInstitutionType($boardUniversity){
            $institutionTypeRepository = new InstitutionTypeRepository();
            $courseMasterRepository = new CourseMasterRepository();
            $dataArray = array();
            $institutionTypeDetails = $courseMasterRepository->fetchInstitutionType($boardUniversity);

            foreach($institutionTypeDetails as $index => $type)
            {
                $institutionType = $institutionTypeRepository->fetch($type->institution_type);
               
                $data = array(
                    'id' => $type->institution_type,
                    'label' => $institutionType->type_name
                );
                array_push($dataArray, $data);
            }
            return json_encode($dataArray);
        }

        public function getCourse($institutionType, $boardUniversity){
            $courseRepository = new CourseRepository();
            $courseMasterRepository = new CourseMasterRepository();
            $dataArray = array();
            DB::enableQueryLog();
            $courseDetails = $courseMasterRepository->fetchCourse($institutionType, $boardUniversity);
            // dd(DB::getQueryLog());
            foreach($courseDetails as $index => $type)
            {
                $course = $courseRepository->fetch($type->course);
                $data = array(
                    'id' => $type->course,
                    'label' => $course->name
                );
                array_push($dataArray, $data);
            }
            return json_encode($dataArray);
        }

        public function getStream($institutionType, $boardUniversity, $course){
            $streamRepository = new StreamRepository();
            $courseMasterRepository = new CourseMasterRepository();
            $dataArray = array();
            DB::enableQueryLog();
            $streamDetails = $courseMasterRepository->fetchStream($institutionType, $boardUniversity, $course);
            // dd(DB::getQueryLog());
            foreach($streamDetails as $index => $type)
            {
                $stream = $streamRepository->fetch($type->stream);
                $data = array(
                    'id' => $type->stream,
                    'label' => $stream->name
                );
                array_push($dataArray, $data);
            }
            return json_encode($dataArray);
        }

        public function getCombination($institutionType, $boardUniversity, $course, $stream){
            $combinationRepository = new CombinationRepository();
            $courseMasterRepository = new CourseMasterRepository();
            $dataArray = array();
            DB::enableQueryLog();
            $combinationDetails = $courseMasterRepository->fetchCombination($institutionType, $boardUniversity, $course, $stream);
            
            foreach($combinationDetails as $type)
            {
                $combinations = explode(",", $type->combination);
                foreach($combinations as $comb){
                    if(!in_array($comb, $dataArray)){
                       $combination = $combinationRepository->fetch($comb);
                        $data = array(
                            'id' => $comb,
                            'label' => $combination->name
                        );
                        array_push($dataArray, $data);
                    }                    
                }                
            }
            return json_encode($dataArray);
        }


        public function add($courseMasterData)
        {
            $combinationRepository = new CombinationRepository();
            $streamRepository = new StreamRepository();
            $courseRepository = new CourseRepository();
            $institutionTypeRepository = new InstitutionTypeRepository();
            $boardRepository = new BoardRepository();
            $courseMasterRepository = new CourseMasterRepository();
            $storeCount = 0;
            $failedCount = 0;
            $existCount = 0;
            
            foreach($courseMasterData->board_university as $key=>$boardUniversity) 
            {
                if($boardUniversity !='')
                {
                    $institutionType = $courseMasterData->institution_type[$key];
                    $course = $courseMasterData->course[$key];
                    $stream = $courseMasterData->stream[$key];
                    $combination = $courseMasterData->combination[$key];

                    // save board and university
                    $boardUniversityCheck = Board::where('name', $boardUniversity)->first();
                    if($boardUniversityCheck)
                    {
                        $boardUniversityId = $boardUniversityCheck->id;
                        
                    }else
                    {
                        $boardUniversityData = array(
                                'name' => $boardUniversity,
                                'created_by' => Session::get('userId'),
                                'modified_by' => ''
                        );

                        $storeBoardUniversityData = $boardRepository->store($boardUniversityData);
                        $boardUniversityId = $storeBoardUniversityData->id;
                    }
                
                    // save institution type
                    $institutionTypeCheck = InstitutionType::where('type_name', $institutionType)->first();
                    if($institutionTypeCheck)
                    {
                        $institutionTypeId = $institutionTypeCheck->id;
                    }
                    else
                    {
                        $institutionTypeData = array(
                                'type_name' => $institutionType,
                                'created_by' => Session::get('userId'),
                                'modified_by' => ''
                        );
                        $storeInstitutionTypeData = $institutionTypeRepository->store($institutionTypeData);
                        $institutionTypeId = $storeInstitutionTypeData->id;
                    }

                    // save course 
                    $courseCheck = Course::where('name', $course)->first();
                    if($courseCheck){
                        $courseId = $courseCheck->id;
                    }
                    else
                    {
                        $courseData = array(
                                'name' => $course,
                                'created_by' => Session::get('userId'),
                                'modified_by' => ''
                        );
                        $storeCourseData = $courseRepository->store($courseData);
                        $courseId = $storeCourseData->id;
                    }

                    // save stream 
                    $streamCheck = Stream::where('name', $stream)->first();
                    if($streamCheck){
                         $streamId = $streamCheck->id;
                    }
                    else
                    {
                        $streamData = array(
                                'name' => $stream,
                                'created_by' => Session::get('userId'),
                                'modified_by' => ''
                        );
                        $storeStreamData = $streamRepository->store($streamData);
                        $streamId = $storeStreamData->id;
                    }

                    // save combination 
                    $combinationIdArray = array();
                    $combinationArray = explode(',', $combination);
                  
                    foreach ($combinationArray as $index => $comb)
                    {
                        $combinationCheck = Combination::where('name', $comb)->first();
                        if($combinationCheck){
                            $combinationId = $combinationCheck->id;
                        }
                        else
                        {
                            $combinationData = array(
                                    'name' => $comb,
                                    'created_by' => Session::get('userId'),
                                    'modified_by' => ''
                            );
                            $storeCombinationData = $combinationRepository->store($combinationData);
                            $combinationId = $storeCombinationData->id;
                        }
                        $combinationIdArray[$key][$index] = $combinationId;
                    }
                    
                    $combinationIds = implode(',', $combinationIdArray[$key]);
                    $check = CourseMaster::where('board_university', $boardUniversityId)->where('institution_type', $institutionTypeId)->where('course', $courseId)->where('stream', $streamId)->where('combination', $combinationIds)->first();

                    if(!$check)
                    {
                        $data = array(
                        'board_university' => $boardUniversityId,
                        'institution_type' => $institutionTypeId,
                        'course' => $courseId,
                        'stream' => $streamId,
                        'combination' => $combinationIds,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                        );
                        $storeData = $courseMasterRepository->store($data);

                        if($storeData)
                        {
                            $storeCount = $storeCount+1;
                        }else
                        {
                            $failedCount = $failedCount+1;
                        } 
                    }
                    else
                    {
                        $existCount = $existCount+1;
                    } 
                }
                
            }
            $signal = 'success';
            $msg = $storeCount.' Data Inserted ,  '.$existCount.' Data Exist ';
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;  
        }

        public function update($courseMasterData, $id){
            $courseMasterRepository = new CourseMasterRepository();
                        
            $check = CourseMaster::where('name', $courseMasterData->courseMaster)->where('id', '!=', $id)->first();
            if(!$check){

                $data = array(
                    'name' => $courseMasterData->courseMaster, 
                    'modified_by' => Session::get('userId'),
                    'updated_at' => Carbon::now()
                );

                $storeData = $courseMasterRepository->update($data, $id); 
              
                if($storeData) {
                    $storeCount++;
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
            $courseMasterRepository = new CourseMasterRepository();
            $institutionCourseMasterRepository = new InstitutionCourseMasterRepository();

            $courseMasterData = $courseMasterRepository->fetch($id);
            
            $checkMapping = $institutionCourseMasterRepository->checkCourseMasterExistence($courseMasterData->board_university, $courseMasterData->institution_type, $courseMasterData->course, $courseMasterData->stream, $courseMasterData->combination);
            // dd($checkMapping);
            if(!$checkMapping){
                $courseMaster = $courseMasterRepository->delete($id);

                if($courseMaster){
                    $signal = 'success';
                    $msg = 'CourseMaster deleted successfully!';
                }else{
                    $signal = 'failure';
                    $msg = 'error in deleting data';
                }
            }else{
                $signal = 'invalid';
                $msg = 'CourseMaster can\'t be deleted!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }


        public function getCourseDetails($boardUniversity){
            $courseRepository = new CourseRepository();
            $courseMasterRepository = new CourseMasterRepository();
            $dataArray = array();
            DB::enableQueryLog();
            $courseDetails = $courseMasterRepository->fetchCourseDetails($boardUniversity);
         
            foreach($courseDetails as $index => $type)
            {
                $course = $courseRepository->fetch($type->course);
                $data = array(
                    'id' => $type->course,
                    'label' => $course->name
                );
                array_push($dataArray, $data);
            }
            return json_encode($dataArray);
        }

        public function getStreamDetails($boardUniversity, $course){
            $streamRepository = new StreamRepository();
            $courseMasterRepository = new CourseMasterRepository();
            $dataArray = array();
            DB::enableQueryLog();
            $streamDetails = $courseMasterRepository->fetchStreamDetails($boardUniversity, $course);
            foreach($streamDetails as $index => $type)
            {
                $stream = $streamRepository->fetch($type->stream);
                $data = array(
                    'id' => $type->stream,
                    'label' => $stream->name
                );
                array_push($dataArray, $data);
            }
            return json_encode($dataArray);
        }

        public function getCombinationDetails($boardUniversity, $course, $stream){
            $combinationRepository = new CombinationRepository();
            $courseMasterRepository = new CourseMasterRepository();
            $dataArray = array();
            DB::enableQueryLog();
            $combinationDetails = $courseMasterRepository->fetchCombinationDetails($boardUniversity, $course, $stream);
            foreach($combinationDetails as $type)
            {
                $combinations = explode(",", $type->combination);
                foreach($combinations as $comb){
                    $combination = $combinationRepository->fetch($comb);
                    if(!in_array($comb, $dataArray)){
                        $data = array(
                            'id' => $comb,
                            'label' => $combination->name
                        );
                        array_push($dataArray, $data);
                    }                    
                }                
            }
            return json_encode($dataArray);
        }
    }

?>