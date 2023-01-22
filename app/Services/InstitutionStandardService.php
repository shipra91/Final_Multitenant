<?php
    namespace App\Services;
<<<<<<< HEAD

    use App\Models\InstitutionStandard;
    use App\Repositories\InstitutionStandardRepository;
    use App\Repositories\CourseRepository;
=======
    use App\Models\InstitutionStandard;
    use App\Repositories\InstitutionStandardRepository;
>>>>>>> main
    use App\Interfaces\InstitutionStandardRepositoryInterface;
    use App\Services\InstituteService;
    use App\Services\StandardService;
    use App\Services\DivisionService;
    use App\Services\StreamService;
    use App\Services\CombinationService;
    use App\Services\SubjectService;
    use App\Services\OrganizationService;
    use App\Services\YearSemService;
    use App\Services\StandardSubjectService;
    use App\Services\BoardService;
    use App\Services\InstitutionBoardService;
    use App\Services\StandardSubjectStaffMappingService;
    use App\Services\CourseService;
    use Carbon\Carbon;
    use Session;
    use DB;

    class InstitutionStandardService {

<<<<<<< HEAD
        public function all(){
=======
        public function all($allSessions){
>>>>>>> main

            $boardService = new BoardService();
            $yearSemService = new YearSemService();
            $combinationService = new CombinationService();
            $streamService = new StreamService();
            $divisionService = new DivisionService();
            $institutionBoardService = new InstitutionBoardService();
            $standardService = new StandardService();
            $institutionStandardRepository = new InstitutionStandardRepository();
<<<<<<< HEAD

            $institutionStandardDetails = array();
            $institutionStandard = $institutionStandardRepository->all();
=======
            $institutionStandardDetails = array();
            $institutionStandard = $institutionStandardRepository->all($allSessions);
>>>>>>> main

            foreach($institutionStandard as $data){

                $standardName = $divisionName = $streamName = $combinationName = $boardName = $yearName = $semName = '';

                $standard = $standardService->find($data->id_standard);
<<<<<<< HEAD

=======
>>>>>>> main
                if($standard){
                    $standardName = $standard->name;
                }

                $division = $divisionService->find($data->id_division);
                if($division){
                    $divisionName = $division->name;
                }

                $stream = $streamService->find($data->id_stream);
                if($stream){
                    $streamName = $stream->name;
                }

                $combination = $combinationService->find($data->id_combination);
                if($combination){
                    $combinationName = $combination->name;
                }

                $board = $boardService->find($data->id_board);
                if($board){
                    $boardName = $board->name;
                }

                if($data->standard_type	 != 'general'){

                    $year = $yearSemService->find($data->id_year);
                    if($year){
                        $yearName = $year->name;
                    }

                    $sem = $yearSemService->findSem($data->id_sem);
                    if($sem){
                        $semName = $sem->name;
                    }
                }

                $institutionStandardId = $data->id;

                $institutionStandardArray = array(
                    'id' => $institutionStandardId,
                    'standard' => $standardName,
                    'division' => $divisionName,
                    'stream' => $streamName,
                    'combination' => $combinationName,
                    'board' => $boardName,
                    'year' => $yearName,
                    'sem' => $semName
                );

                $institutionStandardDetails[$data->id] = $institutionStandardArray;
            }

            return $institutionStandardDetails;
        }

<<<<<<< HEAD
        public function fetchStandard(){

=======
        public function fetchStandard($allSessions){

            // DB::enableQueryLog();
>>>>>>> main
            $boardService = new BoardService();
            $yearSemService = new YearSemService();
            $combinationService = new CombinationService();
            $streamService = new StreamService();
            $divisionService = new DivisionService();
            $standardService = new StandardService();
            $institutionStandardRepository = new InstitutionStandardRepository();
<<<<<<< HEAD

            $institutionStandardDetails = array();
            $standardDetails = array();
            $standardArray = array();

            $institutionStandard = $institutionStandardRepository->all();

=======
            $institutionStandardDetails = array();
            $institutionStandard = $institutionStandardRepository->all($allSessions);
            $standardDetails = array();
            $standardArray = array();

>>>>>>> main
            foreach($institutionStandard as $key => $data){

                $standard = $standardService->find($data->id_standard);
                $division = $divisionService->find($data->id_division);
                $stream = $streamService->find($data->id_stream);
                $combination = $combinationService->find($data->id_combination);
                $board = $boardService->find($data->id_board);
                $standardType = $data->standard_type;

                $standardName = $divisionName = $streamName = $combinationName = $boardName = $yearName = $semName = '';

                if($standard){
                    $standardName = $standard->name;
                }

                if($division){
                    $divisionName = $division->name;
                }

                if($stream){
                    $streamName = $stream->name;
                }

                if($combination){
                    $combinationName = $combination->name;
                }

                if($board){
                    $boardName = $board->name;
                }

                if($data->id_year != ''){
                    $year = $yearSemService->find($data->id_year);
                    $yearName = $year->name;
                }

                if($data->id_sem != ''){
                    $sem = $yearSemService->findSem($data->id_sem);
                    $semName = $sem->name;
                }

                $class = $standardName.' '.$divisionName.' '.$streamName.' '.$combinationName.' '.$semName.' '.$boardName;

                $standardArray[$key]['institutionStandard_id'] = $data->id;
                $standardArray[$key]['class'] = $class;
            }

            return $standardArray;
        }

<<<<<<< HEAD
        public function fetchStaffStandard(){

=======
        public function fetchStaffStandard($allSessions){

            $role = $allSessions['role'];
            $idStaff = $allSessions['userId'];
          
            // DB::enableQueryLog();
>>>>>>> main
            $boardService = new BoardService();
            $yearSemService = new YearSemService();
            $combinationService = new CombinationService();
            $standardSubjectStaffMappingService = new StandardSubjectStaffMappingService();
            $streamService = new StreamService();
            $divisionService = new DivisionService();
            $standardService = new StandardService();
            $institutionStandardRepository = new InstitutionStandardRepository();
<<<<<<< HEAD

            $institutionStandardDetails = array();
            $standardDetails = array();

            $allSessions = session()->all();
            $role = $allSessions['role'];
            $idStaff = $allSessions['userId'];

=======
            $institutionStandardDetails = array();
         
>>>>>>> main
            if($role == 'admin' || $role == 'superadmin'){
                $standardData = $institutionStandardRepository->all();
            }else{
                $standardData = $standardSubjectStaffMappingService->fetchStandardUsingStaff($idStaff);
            }
<<<<<<< HEAD
=======
            $standardDetails = array();
>>>>>>> main

            foreach($standardData as $key => $data){

                $standard = $standardService->find($data->id_standard);
                $division = $divisionService->find($data->id_division);
                $stream = $streamService->find($data->id_stream);
                $combination = $combinationService->find($data->id_combination);
                $board = $boardService->find($data->id_board);
                $standardType = $data->standard_type;
                $standardName = $divisionName = $streamName = $combinationName = $boardName = $yearName = $semName = '';

                if($standard){
                    $standardName = $standard->name;
                }

                if($division){
                    $divisionName = $division->name;
                }

                if($stream){
                    $streamName = $stream->name;
                }

                if($combination){
                    $combinationName = $combination->name;
                }

                if($board){
                    $boardName = $board->name;
                }

                if($data->id_year != ''){
                    $year = $yearSemService->find($data->id_year);
                    $yearName = $year->name;
                }

                if($data->id_sem != ''){
                    $sem = $yearSemService->findSem($data->id_sem);
                    $semName = $sem->name;
                }

                $class = $standardName.' '.$divisionName.' '.$streamName.' '.$combinationName.' '.$semName.' '.$boardName;

                $standardArray = array(
                    'institutionStandard_id' => $data->id,
                    'class' => $class
                );

                $standardDetails[$data->id] = $standardArray;
            }

            return $standardDetails;
        }

        public function fetchStandardByUsingId($id){

            $boardService = new BoardService();
            $yearSemService = new YearSemService();
            $combinationService = new CombinationService();
            $streamService = new StreamService();
            $streamService = new StreamService();
            $divisionService = new DivisionService();
            $standardService = new StandardService();
            $institutionStandardRepository = new InstitutionStandardRepository();

<<<<<<< HEAD
            $class = '';
            $data = $institutionStandardRepository->fetch($id);

            if($data){

                $standard = $standardService->find($data->id_standard);
                $division = $divisionService->find($data->id_division);
                $stream = $streamService->find($data->id_stream);
                $combination = $combinationService->find($data->id_combination);
                $board = $boardService->find($data->id_board);

                $standardName = $divisionName = $streamName = $combinationName = $boardName = $yearName = $semName = '';

                if($standard){
                    $standardName = $standard->name;
                }

                if($division){
                    $divisionName = $division->name;
                }

                if($stream){
                    $streamName = $stream->name;
                }

                if($combination){
                    $combinationName = $combination->name;
                }

                if($board){
                    $boardName = $board->name;
                }

                if($data->standard_type == 'year'){

                    $year = $yearSemService->find($data->id_year);
                    if($year){
                        $yearName = $year->name;
                    }

                    $sem = $yearSemService->findSem($data->id_sem);
                    if($sem){
                        $semName = $sem->name;
                    }
                }

                $class = $standardName.' '.$divisionName.' '.$streamName.' '.$combinationName.' '.$semName.' '.$boardName;
            }

=======
            $data = $institutionStandardRepository->fetch($id);
            $standard = $standardService->find($data->id_standard);
            $division = $divisionService->find($data->id_division);
            $stream = $streamService->find($data->id_stream);
            $combination = $combinationService->find($data->id_combination);
            $board = $boardService->find($data->id_board);

            $standardName = $divisionName = $streamName = $combinationName = $boardName = $yearName = $semName = '';

            if($standard){
                $standardName = $standard->name;
            }

            if($division){
                $divisionName = $division->name;
            }

            if($stream){
                $streamName = $stream->name;
            }

            if($combination){
                $combinationName = $combination->name;
            }

            if($board){
                $boardName = $board->name;
            }

            if($data->standard_type == 'year'){

                $year = $yearSemService->find($data->id_year);
                if($year){
                    $yearName = $year->name;
                }

                $sem = $yearSemService->findSem($data->id_sem);
                if($sem){
                    $semName = $sem->name;
                }
            }

            $class = $standardName.' '.$divisionName.' '.$streamName.' '.$combinationName.' '.$semName.' '.$boardName;

>>>>>>> main
            return $class;
        }

        public function find($id){

            $courseService = new CourseService();
            $boardService = new BoardService();
            $yearSemService = new YearSemService();
            $combinationService = new CombinationService();
            $streamService = new StreamService();
            $divisionService = new DivisionService();
            $standardService = new StandardService();
            $institutionStandardRepository = new InstitutionStandardRepository();

            $institutionStandardDetails = array();
            $institutionStandards = $institutionStandardRepository->fetch($id);
            $standard = $standardService->find($institutionStandards->id_standard);
            $division = $divisionService->find($institutionStandards->id_division);
            $stream = $streamService->find($institutionStandards->id_stream);
            $combination = $combinationService->find($institutionStandards->id_combination);
            $board = $boardService->find($institutionStandards->id_board);
            $course = $courseService->find($institutionStandards->id_course);

            $standardName = $divisionName = $streamName = $combinationName = $boardName = '';

            if($standard){
                $standardName = $standard->name;
            }

            if($division){
                $divisionName = $division->name;
            }

            if($stream){
                $streamName = $stream->name;
            }

            if($combination){
                $combinationName = $combination->name;
            }

            if($board){
                $boardName = $board->name;
            }

            if($institutionStandards->id_year != ''){
                $year = $yearSemService->find($institutionStandards->id_year);
                $yearName = $year->name;
            }else{
                $yearName = '';
            }

            if($institutionStandards->id_year != ''){
                $sem = $yearSemService->findSem($institutionStandards->id_sem);
                $semName = $sem->name;
            }else{
                $semName = '';
            }

            $institutionStandardId = $institutionStandards->id;

            $institutionStandardDetails = array(
                'standard' => $standardName,
                'division' => $divisionName,
                'stream' => $streamName,
                'combination' => $combinationName,
                'board' => $boardName,
                'year' => $yearName,
                'sem' => $semName,
                'course' => $course->name,
                'standard_type' => $institutionStandards->standard_type
            );

            return $institutionStandardDetails;
        }

        public function fetchInstitutionstandard($id){

            $institutionStandardRepository = new InstitutionStandardRepository();

            $institutionStandardDetails = '';
            $institutionStandardDetails = $institutionStandardRepository->fetch($id);

            return $institutionStandardDetails;
        }

        public function getData(){

            $institutionBoardService = new InstitutionBoardService();
            $institutionCourseMasterService = new InstitutionCourseMasterService();
            $yearSemService = new YearSemService();
            $standardYearService = new StandardYearService();
            $organizationService = new OrganizationService();
            $divisionService = new DivisionService();
            $standardService = new StandardService();

            $board = array();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $standards = $standardService->getAll();
            $divisions = $divisionService->getAll();
            $organizations = $organizationService->all();
            $years = $standardYearService->getAllYear();
            $boardDetails = $institutionBoardService->getInstitutionBoards($institutionId);

            $allData = array(
                'standard' => $standards,
                'division' => $divisions,
                'boards' => $boardDetails,
                'years' => $years
            );

            return $allData;
        }

        public function add($institutionStandardData){

<<<<<<< HEAD
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
=======
            $institutionStandardRepository = new InstitutionStandardRepository();

            $institutionId = $institutionStandardData->id_institute;
            $academicYear = $institutionStandardData->id_academic;
>>>>>>> main

            if($institutionStandardData->standard_type != 'general'){

                if($institutionStandardData->standard_year != ''){
                    $standardYear = $institutionStandardData->standard_year;
                }else{
                    $standardYear = '';
                }

                if($institutionStandardData->standard_sem != ''){
                    $standardSem = $institutionStandardData->standard_sem;
                }else{
                    $standardSem = '';
                }

            }else{
                $standardYear = '';
                $standardSem = '';
            }

<<<<<<< HEAD
            foreach($institutionStandardData->division as $division){

                $institutionStandardRepository = new InstitutionStandardRepository();

                $check = InstitutionStandard::where('id_institute', $institutionId)
                                            ->where('id_academic_year', $academicYear)
                                            ->where('id_standard', $institutionStandardData->standard)
                                            ->where('id_division', $division)
                                            ->where('id_year', $institutionStandardData->year)
                                            ->where('id_sem', $institutionStandardData->sem)
                                            ->where('id_stream', $institutionStandardData->stream)
                                            ->where('id_combination', $institutionStandardData->combination)
                                            ->where('id_board', $institutionStandardData->board)
                                            ->where('id_course', $institutionStandardData->course)
                                            ->where('standard_type', $institutionStandardData->standard_type)
                                            ->first();
                if(!$check){

=======
            foreach($institutionStandardData->division as $division)
            {
                $check = InstitutionStandard::where('id_institute', $institutionId)->where('id_academic_year', $academicYear)->where('id_standard', $institutionStandardData->standard)->where('id_division', $division)->where('id_year', $institutionStandardData->year)->where('id_sem', $institutionStandardData->sem)->where('id_stream', $institutionStandardData->stream)->where('id_combination', $institutionStandardData->combination)->where('id_board', $institutionStandardData->board)->where('id_course', $institutionStandardData->course)->where('standard_type', $institutionStandardData->standard_type)->first();
                if(!$check)
                {
>>>>>>> main
                    $data = array(
                        'id_academic_year' => $academicYear,
                        'id_institute' => $institutionId,
                        'id_standard' => $institutionStandardData->standard,
                        'id_division' => $division,
                        'id_year' => $standardYear,
                        'id_sem' => $standardSem,
                        'id_stream' => $institutionStandardData->stream,
                        'id_combination' => $institutionStandardData->combination,
                        'id_board' => $institutionStandardData->board,
                        'id_course' => $institutionStandardData->course,
                        'standard_type' => $institutionStandardData->standard_type,
                        'created_by' => Session::get('userId'),
                    );

                    $response = $institutionStandardRepository->store($data);
<<<<<<< HEAD

                    if($response){
                        $signal = 'success';
                        $msg = 'Data inserted successfully!';
                    }else{
                        $signal = 'failure';
                        $msg = 'Error inserting data!';
                    }

=======
                    if($response)
                    {
                        $signal = 'success';
                        $msg = 'Data inserted successfully!';
                    }
                    else
                    {
                        $signal = 'failure';
                        $msg = 'Error inserting data!';
                    }
>>>>>>> main
                }else{
                    $signal = 'exist';
                    $msg = 'This data already exists!';
                }
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

<<<<<<< HEAD
        public function fetchStandardName(){

            $standardService = new StandardService();
            $streamService = new StreamService();
            $institutionStandardRepository = new InstitutionStandardRepository();

            $standardStreamDetails['data'] = array();

            $institutionStandardDetails = $institutionStandardRepository->fetchStandard();
=======
        public function fetchStandardName($allSessions){

            $standardService = new StandardService();
            $streamService = new StreamService();
            $standardStreamDetails['data'] = array();
            $institutionStandardRepository = new InstitutionStandardRepository();
            $institutionStandardDetails = $institutionStandardRepository->fetchStandard($allSessions);
>>>>>>> main

            foreach($institutionStandardDetails as $key => $data){

                $standardDetails = $standardService->find($data->id_standard);
                $streamData = $institutionStandardRepository->fetchStreams($data->id_standard);

                foreach($streamData as $index => $details){
<<<<<<< HEAD
=======

>>>>>>> main
                    $standardData['id'] = $data->id_standard.'/'.$details->id_stream;
                    $streamDetails = $streamService->find($details->id_stream);
                    $standardData['standard'] = $standardDetails->name;
                    $standardData['stream'] = $streamDetails->name;
                    array_push($standardStreamDetails['data'], $standardData);
                }
            }

            return $standardStreamDetails;
        }

        public function fetchCombinationDivision($idStandard){

            $divisionService = new DivisionService();
            $combinationService = new CombinationService();
            $institutionStandardRepository = new InstitutionStandardRepository();
<<<<<<< HEAD

            $combinationName = $divisionName = '';
            $institutionStandardDetails = $institutionStandardRepository->fetch($idStandard);

            $combinationDetails = $combinationService->find($institutionStandardDetails->id_combination);

=======
            $institutionStandardDetails = $institutionStandardRepository->fetch($idStandard);
            $combinationName = $divisionName = '';

            $combinationDetails = $combinationService->find($institutionStandardDetails->id_combination);
>>>>>>> main
            if($combinationDetails){
                $combinationName = $combinationDetails->name;
            }

            $divisionDetails = $divisionService->find($institutionStandardDetails->id_division);
<<<<<<< HEAD

=======
>>>>>>> main
            if($divisionDetails){
                $divisionName = $divisionDetails->name;
            }

            $standardStreamDetails = $combinationName.' '.$divisionName;

            return $standardStreamDetails;
        }

<<<<<<< HEAD
        public function fetchStandardDetails($request){
            $institutionStandardRepository = new InstitutionStandardRepository();
            return $institutionStandardRepository->fetchStandardDetails($request);
        }

        public function fetchStandardGroupByCombination(){
=======
        public function fetchStandardDetails($request, $allSessions){

            $institutionStandardRepository = new InstitutionStandardRepository();

            return $institutionStandardRepository->fetchStandardDetails($request, $allSessions);
        }

        public function fetchStandardGroupByCombination($allSessions){
>>>>>>> main

            $institutionStandardRepository = new InstitutionStandardRepository();

            // return $institutionStandardRepository->fetchStandardGroupByCombination();
<<<<<<< HEAD
=======

            $role = $allSessions['role'];
            $idStaff = $allSessions['userId'];

>>>>>>> main
            $boardService = new BoardService();
            $yearSemService = new YearSemService();
            $combinationService = new CombinationService();
            $standardSubjectStaffMappingService = new StandardSubjectStaffMappingService();
            $streamService = new StreamService();
            $divisionService = new DivisionService();
            $standardService = new StandardService();
            $institutionStandardRepository = new InstitutionStandardRepository();
<<<<<<< HEAD

            $institutionStandardDetails = array();

            $allSessions = session()->all();
            $role = $allSessions['role'];
            // $role = 'staff';
            $idStaff = $allSessions['userId'];

            if($role == 'admin' || $role == 'superadmin'){
                $standardData = $institutionStandardRepository->fetchStandardGroupByCombination();
            }else{
                $standardData = $standardSubjectStaffMappingService->fetchStandardUsingStaff($idStaff);
=======
            $institutionStandardDetails = array();

            if($role == 'admin' || $role == 'superadmin'){
                $standardData = $institutionStandardRepository->fetchStandardGroupByCombination($allSessions);
            }else{
                $standardData = $standardSubjectStaffMappingService->fetchStandardUsingStaff($idStaff, $allSessions);
>>>>>>> main
            }

            $standardDetails = array();

            foreach($standardData as $key => $data){

                $standard = $standardService->find($data->id_standard);
                //$division = $divisionService->find($data->id_division);
                $stream = $streamService->find($data->id_stream);
                $combination = $combinationService->find($data->id_combination);
                $board = $boardService->find($data->id_board);
                $standardType = $data->standard_type;
                $standardName = $divisionName = $streamName = $combinationName = $boardName = $yearName = $semName = '';

                if($standard){
                    $standardName = $standard->name;
                }

                // if($division){
                //     $divisionName = $division->name;
                // }

                if($stream){
                    $streamName = $stream->name;
                }

                if($combination){
                    $combinationName = $combination->name;
                }

                if($board){
                    $boardName = $board->name;
                }

                if($data->id_year != ''){
                    $year = $yearSemService->find($data->id_year);
                    $yearName = $year->name;
                }

                if($data->id_sem != ''){
                    $sem = $yearSemService->findSem($data->id_sem);
                    $semName = $sem->name;
                }

                //$class = $standardName.' '.$divisionName.' '.$streamName.' '.$combinationName.' '.$semName.' '.$boardName;
                $class = $standardName.' '.$streamName.' '.$combinationName.' '.$semName.' '.$boardName;

                $standardArray = array(
                    'institutionStandard_id' => $data->id,
                    'class' => $class
                );

                $standardDetails[$data->id] = $standardArray;
            }

            return $standardDetails;
        }

        public function fetchPreadmissionStandardByUsingId($id){

            $boardService = new BoardService();
            $yearSemService = new YearSemService();
            $combinationService = new CombinationService();
            $streamService = new StreamService();
            $streamService = new StreamService();
            $standardService = new StandardService();
            $institutionStandardRepository = new InstitutionStandardRepository();

            $data = $institutionStandardRepository->fetch($id);
            $standard = $standardService->find($data->id_standard);
            $stream = $streamService->find($data->id_stream);
            $combination = $combinationService->find($data->id_combination);
            $board = $boardService->find($data->id_board);

            $standardName =  $streamName = $combinationName = $boardName = $yearName = $semName = '';

            if($standard){
                $standardName = $standard->name;
            }

            if($stream){
                $streamName = $stream->name;
            }

            if($combination){
                $combinationName = $combination->name;
            }

            if($board){
                $boardName = $board->name;
            }

            if($data->standard_type == 'year'){

                $year = $yearSemService->find($data->id_year);
                if($year){
                    $yearName = $year->name;
                }

                $sem = $yearSemService->findSem($data->id_sem);
                if($sem){
                    $semName = $sem->name;
                }
            }

            $class = $standardName.' '.$streamName.' '.$combinationName.' '.$semName.' '.$boardName;

            return $class;
        }

        public function fetchStandardDivisions($idStandard, $idYear, $idSem, $idStream, $idCombination){

            $divisionService = new DivisionService();
            $combinationService = new CombinationService();
            $institutionStandardRepository = new InstitutionStandardRepository();
<<<<<<< HEAD

            $institutionStandardDivisions = $institutionStandardRepository->getDivisions($idStandard, $idYear, $idSem, $idStream, $idCombination);
            return $institutionStandardDivisions;
        }

        public function fetchAllInstitutionStandard(){

            $boardService = new BoardService();
            $yearSemService = new YearSemService();
            $combinationService = new CombinationService();
            $streamService = new StreamService();
            $divisionService = new DivisionService();
            $standardService = new StandardService();
            $institutionStandardRepository = new InstitutionStandardRepository();
            $courseRepository = new CourseRepository();

            $institutionStandardDetails = array();
            $standardDetails = array();
            $standardArray = array();

            $institutionStandard = $institutionStandardRepository->all();

            foreach($institutionStandard as $key => $data){

                $standard = $standardService->find($data->id_standard);
                $division = $divisionService->find($data->id_division);
                $stream = $streamService->find($data->id_stream);
                $combination = $combinationService->find($data->id_combination);
                $board = $boardService->find($data->id_board);
                $course = $courseRepository->fetch($data->id_course);
                $standardType = $data->standard_type;

                $standardName = $divisionName = $streamName = $combinationName = $boardName = $yearName = $semName = $courseName = '';

                if($standard){
                    $standardName = $standard->name;
                }

                if($division){
                    $divisionName = $division->name;
                }

                if($stream){
                    $streamName = $stream->name;
                }

                if($combination){
                    $combinationName = $combination->name;
                }

                if($board){
                    $boardName = $board->name;
                }

                if($course){
                    $courseName = $course->name;
                }

                if($data->id_year != ''){
                    $year = $yearSemService->find($data->id_year);
                    $yearName = $year->name;
                }

                if($data->id_sem != ''){
                    $sem = $yearSemService->findSem($data->id_sem);
                    $semName = $sem->name;
                }

                $class = $standardName.'::'.$divisionName.'::'.$streamName.'::'.$courseName.'::'.$combinationName.'::'.$semName.'::'.$boardName;

                $standardArray[$key]['institutionStandard_id'] = $data->id;
                $standardArray[$key]['class'] = $class;
            }

            return $standardArray;
        }
    }
=======
            $institutionStandardDivisions = $institutionStandardRepository->getDivisions($idStandard, $idYear, $idSem, $idStream, $idCombination);

            return $institutionStandardDivisions;
        }
    }
?>
>>>>>>> main
