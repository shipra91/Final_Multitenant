<?php
    namespace App\Services;

    use App\Models\Staff;;
    use App\Repositories\StaffRepository;
    use App\Repositories\ClassTimeTableSettingsRepository;
    use App\Repositories\ClassTimeTableRepository;
    use App\Repositories\ClassTimeTableDetailRepository;
    use App\Repositories\PeriodRepository;
    use App\Repositories\RoomMasterRepository;
    use App\Services\InstitutionStandardService;
    use App\Services\InstitutionSubjectService;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class StaffClassTimeTableService {

        // Get all staff
        public function getAll(){

            $staffRepository = new StaffRepository();

            $staffData = $staffRepository->allStaff();
            return $staffData;
        }

        // public function getAllTeachingStaff(){

        //     $staffRepository = new StaffRepository();

        //     $staffData = $staffRepository->getTeachingStaff();
        //     return $staffData;
        // }

        public function getAllTeachingStaff(){

            $staffRepository = new StaffRepository();

            $arrayData = array();
            $staffData = $staffRepository->getTeachingStaff();

            foreach($staffData as $key => $staffDetail){
                $arrayData[$key] = $staffDetail;
                $arrayData[$key]['name'] = $staffRepository->getFullName($staffDetail['name'], $staffDetail['middle_name'], $staffDetail['last_name']);
            }

            return $arrayData;
        }

        // Get particular staff time table
        public function getStaffTimeTableData($staffId){

            $staffRepository = new StaffRepository();
            $classTimeTableRepository = new ClassTimeTableRepository();
            $classTimeTableDetailRepository = new ClassTimeTableDetailRepository();
            $classTimeTableSettingsRepository = new ClassTimeTableSettingsRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $periodRepository = new PeriodRepository();
            $roomMasterRepository = new RoomMasterRepository();

            $classTimetableArray = [];
            $classTimetableDetalsArray = [];

            $daysArray = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $periodData = $periodRepository->getPeriodTypeWise();
            $classTimetableDetalsArray['days'] = $daysArray;
            $classTimetableDetalsArray['periodData'] = $periodData;

            $staffData = $staffRepository->fetch($staffId);
            //$classTimetableDetalsArray['staff_name'] = $staffData->name;
            $classTimetableDetalsArray['staff_name'] = $staffRepository->getFullName($staffData->name, $staffData->middle_name, $staffData->last_name);

            foreach($periodData as $index => $period){

                foreach($daysArray as $key => $day){

                    $classTimetableArray[$index]['timetable'][$key]['day'] = $day;
                    $timeTableData = $classTimeTableRepository->fetchClassTimeTableData($staffId, $day, $period['id']);
                    $roomName = '';

                    if($timeTableData){

                        $periodDetails = $periodRepository->fetch($timeTableData->id_period);
                        $standardDetails = $institutionStandardService->fetchStandardByUsingId($timeTableData->id_standard);
                        $subjectDetails =  $institutionSubjectService->getSubjectName($timeTableData->id_subject);

                        if($timeTableData->id_room){
                            $roomDetails = $roomMasterRepository->fetch($timeTableData->id_room);
                            $roomName = '( '.$roomDetails->display_name.' )';
                        }

                        $classTimetableArray[$index]['timetable'][$key]['period']     = $period->name;
                        $classTimetableArray[$index]['timetable'][$key]['standard']   = $standardDetails;
                        $classTimetableArray[$index]['timetable'][$key]['subject']    = $subjectDetails;
                        $classTimetableArray[$index]['timetable'][$key]['start_time'] = $timeTableData->start_time;
                        $classTimetableArray[$index]['timetable'][$key]['end_time']   = $timeTableData->end_time;
                        $classTimetableArray[$index]['timetable'][$key]['room_name']  = $roomName;

                    }else{

                        $classTimetableArray[$index]['timetable'][$key]['period']     = $period->name;
                        $classTimetableArray[$index]['timetable'][$key]['standard']   = '';
                        $classTimetableArray[$index]['timetable'][$key]['subject']    = '';
                        $classTimetableArray[$index]['timetable'][$key]['start_time'] = '';
                        $classTimetableArray[$index]['timetable'][$key]['end_time']   = '';
                        $classTimetableArray[$index]['timetable'][$key]['room_name']  = '';
                    }
                }
            }

            $classTimetableDetalsArray['classTimetable'] = $classTimetableArray;
            // dd($classTimetableDetalsArray);
            return $classTimetableDetalsArray;
        }
    }
