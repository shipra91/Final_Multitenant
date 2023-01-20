<?php
    namespace App\Services;
    use App\Models\ClassTimeTable;
    use App\Models\ClassTimeTableDetail;
    use App\Repositories\ClassTimeTableRepository;
    use App\Repositories\ClassTimeTableDetailRepository;
    use App\Repositories\PeriodSettingsRepository;
    use App\Repositories\PeriodRepository;
    use App\Repositories\ClassTimeTableSettingsRepository;
    use App\Repositories\StandardSubjectRepository;
    use App\Repositories\StandardSubjectStaffMappingRepository;
    use App\Services\InstitutionStandardService;
    use App\Services\StandardSubjectService;
    use App\Services\StaffService;
    use App\Services\InstitutionSubjectService;
    use Carbon\Carbon;
    use Session;

    class ClassTimeTableService {

        // Get standards
        public function getStandards(){

            $institutionStandardService = new InstitutionStandardService();

            $institutionStandards = $institutionStandardService->fetchStandard();

            $output = array(
                'institutionStandards' => $institutionStandards,
            );
            // dd($output);
            return $output;
        }

        // Get time-table daywise
        public function getTimeTableDayWise($standardId){

            $staffService = new StaffService();
            $periodRepository = new PeriodRepository();
            $periodSettingsRepository = new PeriodSettingsRepository();
            $classTimeTableSettingsRepository = new ClassTimeTableSettingsRepository();
            $classTimeTableDetailRepository = new ClassTimeTableDetailRepository();
            $standardSubjectService = new StandardSubjectService();
            $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();

            $daysArray = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $classTimeTableSettingData = array();
            $dayPeriodSettingData = array();
            $classSelectedData = array();
            $allSubjects = array();
            $daysPeriodDetails = array();

            $allSubjects = $standardSubjectService->fetchStandardSubjects($standardId);
            $daysPeriodDetails['days_array'] = $daysArray;
            foreach($daysArray as $index => $day){

                $dayPeriodSetting = $periodSettingsRepository->getPeriodSettings($standardId, $day);
                if($dayPeriodSetting){
                    
                    $dayPeriodSettingData[$index] = $dayPeriodSetting;

                    $classTimeTableSettingDetails = $classTimeTableSettingsRepository->getClassTimetableSettings($dayPeriodSetting->id);
                    
                    if($classTimeTableSettingDetails){

                        foreach($classTimeTableSettingDetails as $key => $timetableSetting){
                           
                            $daysPeriodDetails['day_periods'][$day][] = $timetableSetting->id_period;
                            $classTimeTableSettingData[$key] = $timetableSetting;

                            $classSelectedData = $this->getTimeTableSelectedData($standardId, $day, $timetableSetting->id_period);
                           
                            $classTimeTableSettingData[$key]['selected_subject'] = $classTimeTableSettingData[$key]['selected_staff'] = $classTimeTableSettingData[$key]['selected_room'] = $classTimeTableSettingData[$key]['all_staff'] = array();
                            $classTimeTableSettingData[$key]['count'] = 0;
                          
                            if($classSelectedData) {
                               
                                $count = 0;
                                $allSubjectArray = $allSubjectArray['selectedStaff'] = $allStaffArray = $allRoomArray =  $allStaffDetailsArray = array();
                                $classTimeTableAllDetails = $classTimeTableDetailRepository->fetch($classSelectedData->id);
                                
                                foreach($classTimeTableAllDetails as $sub => $detail){
                                 
                                    $staffDetails = array();
                                    $count++;
                                    
                                    $selectedStaff = explode(',', $detail['id_staffs']);

                                    $allSubjectArray[$sub] = $detail['id_subject'];
                                    $allStaffArray[$detail['id_subject']] = explode(',', $detail['id_staffs']);
                                    $allRoomArray[$detail['id_subject']][$sub] = $detail['id_room'];

                                    $standardSubjectStaffData = $standardSubjectStaffMappingRepository->fetchStaffOnStandardAndSubject($standardId, $detail['id_subject']);

                                    foreach($standardSubjectStaffData as $staffKey => $staffData) {

                                        if(!in_array($staffData->id , $staffDetails)) {

                                            array_push($staffDetails, $staffData->id);
                                            
                                            $allStaffDetailsArray[$detail['id_subject']][$staffKey] = $staffData;
                                        }
                                    }
                                }
                               
                                $classTimeTableSettingData[$key]['selected_subject'] = $allSubjectArray;
                                $classTimeTableSettingData[$key]['selected_staff'] = $allStaffArray;
                                $classTimeTableSettingData[$key]['selected_room'] = $allRoomArray;
                                $classTimeTableSettingData[$key]['all_staff'] = $allStaffDetailsArray;
                                $classTimeTableSettingData[$key]['count'] = count($allSubjectArray);
                            }
                           
                        }
                    }
                //    dd($classTimeTableSettingData);
                    $dayPeriodSettingData[$index]['classTimeTableSettingData'] = $classTimeTableSettingData;
                }
            }

            $output = array(
                'dayPeriodSettingData' => $dayPeriodSettingData,
                'subjects' => $allSubjects,
                'daysPeriodDetails' => $daysPeriodDetails,

            );
            // dd($output);
            return $output;
        }

        // Insert and update time-table
        public function add($timeTableData){
            //dd($timeTableData);
            $classTimeTableRepository = new ClassTimeTableRepository();
            $classTimeTableDetailRepository = new ClassTimeTableDetailRepository();
            $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $idStandard = $timeTableData->standard_id;
            $count = 0;

            foreach($timeTableData->day as $key => $day){

                $staffArray = array();
                $idPeriods = $timeTableData->periodId[$day];

                foreach($idPeriods as $period){
                    $subjectData = 'subject_'.$day.'_'.$period;
                    $room_id = 'room_'.$day.'_'.$period;
                 
                    $subjectDetails = $timeTableData->$subjectData;
                    if(implode(',',$subjectDetails) != ''){
                       
                        $check = ClassTimeTable::where('id_institute', $institutionId)
                                                    ->where('id_academic', $academicYear)
                                                    ->where('id_standard', $idStandard)
                                                    ->where('day', $day)
                                                    ->where('id_period', $period)->first();
                        if(!$check){

                            $data = array(
                                'id_institute' => $institutionId,
                                'id_academic' => $academicYear,
                                'id_standard' => $idStandard,
                                'id_period' => $period,
                                'day' => $day,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeData = $classTimeTableRepository->store($data);
                            $idClassTimeTable = $storeData->id;

                        }else{

                            $idClassTimeTable = $check->id;
                            $updateTimeTableData = $classTimeTableRepository->fetch($idClassTimeTable);
                            $updateTimeTableData->modified_by = Session::get('userId');
                            $updateTimeTableData->updated_at = Carbon::now();

                            $updateTimeTable = $classTimeTableRepository->update($updateTimeTableData);
                        }

                        if($idClassTimeTable){

                            // Insert class time-table 
                            $deleteDetailData = $classTimeTableDetailRepository->delete($idClassTimeTable);

                            foreach($timeTableData->$subjectData as $index => $subject){

                                if($subject != ''){
                                    $idRoom = '';
                                    $staffData = 'staff_'.$day.'_'.$period.'_'.$index+1;
                                    $staff = implode(",", $timeTableData->$staffData);

                                    if($timeTableData->$room_id[$index]){
                                        $idRoom = $timeTableData->$room_id[$index];
                                    }
                                    // $checkIfMapped = $standardSubjectStaffMappingRepository->checkSubjectStaffs($subject, $staff, $idStandard);
                                    // dd($checkIfMapped);
                                    // if($checkIfMapped){

                                        $data = array(
                                            'id_class_time_table' => $idClassTimeTable,
                                            'id_subject' => $subject,
                                            'id_staffs' => $staff,
                                            'id_room' => $idRoom,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );
                                    
                                        $storeTimeTableDetail = $classTimeTableDetailRepository->store($data);

                                        if($storeTimeTableDetail){
                                            $count++;
                                        }
                                       
                                    // }
                                }                                    
                            }
                        }
                    }
                }
            }
            if($count > 0){

                $signal = 'success';
                $msg = 'Data inserted successfully!';

            }else{

                $signal = 'failure';
                $msg = 'Error inserting data!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Get particular time-table data
        public function getTimeTableSelectedData($idStandard, $day, $idPeriod){

            $classTimeTableRepository = new ClassTimeTableRepository();

            $timeTableDetailData = $classTimeTableRepository->fetchTimeTableDetail($idStandard, $day, $idPeriod);

            return $timeTableDetailData;
        }

        public function fetchPeriodSubjects($standardId, $periodId, $attendanceDate, $allSessions){
            $classTimeTableRepository = new ClassTimeTableRepository();
            $institutionSubjectService = new InstitutionSubjectService();

            $subjectData = array();
            $attendanceDate = Carbon::createFromFormat('d/m/Y', $attendanceDate)->format('Y-m-d');

            $timestamp = strtotime($attendanceDate);
            $day = date('l', $timestamp);

            $timeTableDetailData = $classTimeTableRepository->fetchStandardPeriodData($standardId, $day, $periodId, $allSessions);
            foreach($timeTableDetailData as $key => $data){
                $idInstitutionSubject = $data->id_subject;
                $subjectName = $institutionSubjectService->getSubjectName($idInstitutionSubject);
                $subjectData[$key] = array(
                    'id_institution_subject'=>$idInstitutionSubject,
                    'subject_name'=>$subjectName
                );
            }
            return $subjectData;
        }
    }
?>
