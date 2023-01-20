<?php
    namespace App\Services;
    use App\Repositories\InstitutionCourseMasterRepository;
    use App\Repositories\BoardRepository;
    use App\Repositories\InstitutionTypeRepository;
    use App\Repositories\CourseRepository;
    use App\Repositories\StreamRepository;
    use App\Repositories\CombinationRepository;
    use App\Models\InstitutionCourseMaster;
    use Carbon\Carbon;
    use Session;

    class InstitutionCourseMasterService {
        public function all()
        {
            $institutionCourseMasterRepository = new InstitutionCourseMasterRepository();
            $institutionCourseMaster = $institutionCourseMasterRepository->all();
            return $institutionCourseMaster;
        }

        public function getInstitutionCourseDetails($idInstitution)
        {
            $institutionCourseMasterRepository = new InstitutionCourseMasterRepository();
            return $institutionCourseMasterRepository->fetchInstitutionCourseMaster($idInstitution);
        }

        public function getInstitutionCourseData($idInstitution)
        {
            $institutionCourseMasterRepository = new InstitutionCourseMasterRepository();
            $boardRepository = new BoardRepository();
            $institutionTypeRepository = new InstitutionTypeRepository();
            $courseRepository = new CourseRepository();
            $streamRepository = new StreamRepository();
            $combinationRepository = new CombinationRepository();
            $institutionCourseData = $institutionCourseMasterRepository->fetchInstitutionCourseMaster($idInstitution);

            foreach($institutionCourseData as $institutionCourse) {
                $combinationData = array();
                $boardUniversityData = $boardRepository->fetch($institutionCourse->board_university);
                $institutionTypeData = $institutionTypeRepository->fetch($institutionCourse->institution_type);
                $courseData = $courseRepository->fetch($institutionCourse->course);
                $streamData = $streamRepository->fetch($institutionCourse->stream);
                $combinationDetails = explode(',' ,$institutionCourse->combination);
                foreach($combinationDetails as $combination) {
                    $combinations = $combinationRepository->fetch($institutionCourse->combination);
                    $combinationData[] = $combinations->name;
                }
                $combinationData = implode(',' ,$combinationData);
                $institutionCourseDetails[] = array(
                    'board_university'=>$boardUniversityData->name,
                    'institution_type'=>$institutionTypeData->type_name,
                    'course'=>$courseData->name,
                    'stream'=>$streamData->name,
                    'combination'=>$combinationData,
                    'institution_code'=>$institutionCourse->institution_code
                );
            }
            return $institutionCourseDetails;

        }

        public function store($institutionCourseMasterData, $lastInsertedId)
        {
            $institutionCourseMasterRepository = new InstitutionCourseMasterRepository();
            if($institutionCourseMasterData->board_university[0] !='')
            {
                foreach($institutionCourseMasterData->board_university as $key => $boardUniversity)
                {
                    $institutionType = $institutionCourseMasterData->institution_type[$key];
                    $course = $institutionCourseMasterData->course[$key];
                    $stream = $institutionCourseMasterData->stream[$key];
                    $combination = implode(',' ,$institutionCourseMasterData->combination[$key + 1]);
                    $institutionCode = $institutionCourseMasterData->institution_code[$key];

                    $data = array(
                       'id_institute' => $lastInsertedId,
                       'board_university' => $boardUniversity,
                       'institution_type' => $institutionType,
                       'course' => $course,
                       'stream' => $stream,
                       'combination' => $combination,
                       'institution_code' => $institutionCode,
                       'created_by' => Session::get('userId'),
                       'created_at' => Carbon::now()
                   );

                    $storeInstitutionCourseMaster = $institutionCourseMasterRepository->store($data);
               }
            }
            $signal = 'success';
            $msg = 'Data inserted successfully!';

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;
        }

        public function update($institutionCourseMasterData, $institutionId)
        {
            $institutionCourseMasterRepository = new InstitutionCourseMasterRepository();
            
            if($institutionCourseMasterData->board_university[0] !=''){

                foreach($institutionCourseMasterData->board_university as $key => $boardUniversity){

                    $institutionType = $institutionCourseMasterData->institution_type[$key];
                    $course = $institutionCourseMasterData->course[$key];
                    $stream = $institutionCourseMasterData->stream[$key];
                    $combination = implode(',' ,$institutionCourseMasterData->combination[$key+1]);
                    $institutionCode = $institutionCourseMasterData->institution_code[$key];
                    $id = $institutionCourseMasterData->institutionCourseMasterId[$key];

                    if($id!=''){

                        $model = $institutionCourseMasterRepository->fetch($id);
                        
                        $model->board_university = $boardUniversity;
                        $model->institution_type = $institutionType;
                        $model->course = $course;
                        $model->stream = $stream;
                        $model->combination = $combination;
                        $model->institution_code = $institutionCode;
                        $model->modified_by = Session::get('userId');
                        $model->updated_at = Carbon::now();                       

                        $updateInstitutionCourseMaster = $institutionCourseMasterRepository->update($model);
                    
                    }else{

                        $data = array(
                            'id_institute' => $institutionId,
                            'board_university' => $boardUniversity,
                            'institution_type' => $institutionType,
                            'course' => $course,
                            'stream' => $stream,
                            'combination' => $combination,
                            'institution_code' => $institutionCode,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );

                        $storeInstitutionCourseMaster = $institutionCourseMasterRepository->store($data);
                    }
                }
            }
            $signal = 'success';
            $msg = 'Data inserted successfully!';

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;
        }

        public function delete($id)
        {
            $institutionCourseMasterRepository = new InstitutionCourseMasterRepository();
            $response = $institutionCourseMasterRepository->delete($id);

            if($response){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }

