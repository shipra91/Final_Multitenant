<?php
    namespace App\Services;
    use App\Models\ClassTimeTableSettings;
    use App\Models\PeriodSettings;
    use App\Repositories\ClassTimeTableSettingsRepository;
    use App\Repositories\PeriodSettingsRepository;
    use App\Repositories\PeriodRepository;
    use App\Services\InstitutionStandardService;
    use Carbon\Carbon;
    use Session;

    class ClassTimeTableSettingsService {

        public function getAllPeriodSettings($allSessions){

            $periodSettingsRepository = new PeriodSettingsRepository();
            $institutionStandardService = new InstitutionStandardService();

            $periodSettingDetail = array();

            $periodSettingData = $periodSettingsRepository->all($allSessions);

            foreach($periodSettingData as $index => $periodSetting){
                $standardData = $institutionStandardService->fetchStandardByUsingId($periodSetting->id_standard);

                $periodSettingDetail[$index] = $periodSetting;
                $periodSettingDetail[$index]['standard_name'] = $standardData;
            }

            return $periodSettingDetail;
        }

        // Get particular time table data
        public function getTimeTableSelectedData($idTimeTable){

            $periodSettingsRepository = new PeriodSettingsRepository();
            $institutionStandardService = new InstitutionStandardService();
            $classTimeTableSettingsRepository = new ClassTimeTableSettingsRepository();
            $periodRepository = new PeriodRepository();

            $periodSettingsData = $periodSettingsRepository->fetch($idTimeTable);
            $standardData = $institutionStandardService->fetchStandardByUsingId($periodSettingsData->id_standard);
            $periodSettingsData['standard'] = $standardData;
            $timeTableData = $classTimeTableSettingsRepository->getAllTimetableSettings($periodSettingsData->id);

            $periods = $periodRepository->all();
            $arrayPeriod = array();

            foreach($periods as $index => $period){

                $arrayPeriod[$index]['id'] = $period['id'];
                $arrayPeriod[$index]['name'] = $period['name'];
                $arrayPeriod[$index]['type'] = $period['type'];
            }

            $output = array(
                'periodSettingsData' => $periodSettingsData,
                'timeTableData' => $timeTableData,
                'periods' => $periods
            );
            //dd($output);
            return $output;
        }

        // time table settings data
        public function getTimeTableData($allSessions){

            $periodSettingsRepository = new PeriodSettingsRepository();
            $periodRepository = new PeriodRepository();
            $institutionStandardService = new InstitutionStandardService();

            $periodSettings = $periodSettingsRepository->all($allSessions);
            $institutionStandards = $institutionStandardService->fetchStandard($allSessions);
            $periods = $periodRepository->all($allSessions);
            $arrayperiod = array();

            $teachingCount = $periodRepository->periodCount("teaching", $allSessions);
            $breakCount = $periodRepository->periodCount("break", $allSessions);

            $output = array(
                'institutionStandards' => $institutionStandards,
                'teachingCount' => $teachingCount,
                'breakCount' => $breakCount,
            );
            // dd($output);
            return $output;
        }

        // period settings data
        public function getPeriodSettings($request, $allSessions){

            $periodRepository = new PeriodRepository();

            $standardId = implode(",", $request->get('standard'));
            // $noOfDays = $request->get('noOfDays');
            $days = implode(",", $request->get('day'));
            $noOfTeachingPeriods = $request->get('noOfTeachingPeriods');
            $noOfBreakPeriods = $request->get('noOfBreakPeriods');
            $timeInterval = $request->get('timeInterval');

            $totalPeriods = $noOfTeachingPeriods + $noOfBreakPeriods;

            $periods = $periodRepository->all($allSessions);
            $timetableData = array();
            $arrayPeriod = array();

            foreach($periods as $index => $period){

                $arrayPeriod[$index]['id'] = $period['id'];
                $arrayPeriod[$index]['name'] = $period['name'];
                $arrayPeriod[$index]['type'] = $period['type'];
            }

            for($j = 0; $j < $totalPeriods; $j++ ){

                $i = $j + 1;

                // $timeInterval = $timeInterval;
				// $periodStartTime = date('h:i A',strtotime('08:05:00'));
				// $min = $timeInterval * $i;
				// $startTime = strtotime("+".$min." minutes", strtotime($periodStartTime));
				// $periodInterval = date('h:i A', strtotime("+".$timeInterval." minutes", strtotime($periodStartTime)));
				// $endTime = strtotime("+".$min." minutes", strtotime($periodInterval));

                // $timetable = $link->prepare("select *  from timetable_setting where period='Period".$i."' and user_category='".$_SESSIO['user_category']."'  " );
				// $timetable->execute();
				// $data=$timetable->fetch(PDO::FETCH_ASSOC);
				// $period =$data['period_type'];
				// $start_time =$data['start_time'];
				// $end_time =$data['end_time'];
				// if ( $start_time !=''){
				// 	$arrayperiod[$index]['start_time'] = $start_time;
				// } else {
				// 	$arrayperiod[$index]['start_time'] = date('h:i A', $startTime);
				// }
				// if ( $end_time !=''){
				// 	$arrayperiod[$index]['end_time'] = $end_time;
				// }else{
				// 	$arrayperiod[$index]['end_time'] = date('h:i A', $endTime);
				// }

                $timetableData[$j]['periods'] = $arrayPeriod;
                $timetableData[$j]['start_time'] = "";
                $timetableData[$j]['end_time'] = "";
            }

            $output = array(
                'id_standard' => $standardId,
                'days' => $days,
                'no_of_teaching_periods' => $noOfTeachingPeriods,
                'no_of_break_periods' => $noOfBreakPeriods,
                'time_interval' => $timeInterval,
                'total_period' => $totalPeriods,
                'timetableData' => $timetableData
            );

            // dd($output);
            return $output;
        }

        // Insert time table settings
        public function add($timeTableData){

            $periodSettingsRepository = new PeriodSettingsRepository();
            $classTimeTableSettingsRepository = new ClassTimeTableSettingsRepository();
            
            $institutionId = $timeTableData->id_institute;
            $academicYear = $timeTableData->id_academic;

            // dd($timeTableData->standardId);
            $standardId = explode(',',$timeTableData->standardId);
            $days = explode(',',$timeTableData->days);
            $noOfTeachingPeriods = $timeTableData->noOfTeachingPeriods;
            $noOfBreakPeriods = $timeTableData->noOfBreakPeriods;
            $timeInterval = $timeTableData->time_interval;

            foreach($standardId as $standard){

                foreach($days as $day){

                    $check = PeriodSettings::where('id_institute', $institutionId)
                            ->where('id_academic', $academicYear)
                            ->where('id_standard', $standard)
                            ->where('days', $day)->first();

                    if(!$check){

                        $data = array(
                            'id_institute' => $institutionId,
                            'id_academic' => $academicYear,
                            'id_standard' => $standard,
                            'days' => $day,
                            'no_of_teaching_periods' => $noOfTeachingPeriods,
                            'no_of_break_periods' => $noOfBreakPeriods,
                            'time_interval' => $timeInterval,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );

                        $storeData = $periodSettingsRepository->store($data);

                        if($storeData){

                            $lastInsertedId = $storeData->id;

                            if($timeTableData->periodType){

                                foreach($timeTableData->periodType as $key => $period){

                                    $startTime = $timeTableData->startTime[$key];
                                    $endTime = $timeTableData->endTime[$key];

                                    $check = ClassTimeTableSettings::where('id_period_setting', $lastInsertedId)
                                            ->where('id_period', $period)
                                            ->where('start_time', $startTime)
                                            ->where('end_time', $endTime)
                                            ->first();

                                    if(!$check){

                                        $data = array(
                                            'id_institute' => $institutionId,
                                            'id_academic' => $academicYear,
                                            'id_period_setting' => $lastInsertedId,
                                            'id_period' => $period,
                                            'start_time' => $startTime,
                                            'end_time' => $endTime,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeTimeTable = $classTimeTableSettingsRepository->store($data);
                                    }
                                }
                            }

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
                }
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Update time table settings
        public function update($timeTableData, $id){

            $periodSettingsRepository = new PeriodSettingsRepository();
            $classTimeTableSettingsRepository = new ClassTimeTableSettingsRepository();

            foreach($timeTableData->periodType as $key => $period){

                $startTime = $timeTableData->startTime[$key];
                $endTime = $timeTableData->endTime[$key];

                $updateTimeTableData = $classTimeTableSettingsRepository->fetch($timeTableData->id_timeTable[$key]);
                //dd($updateTimeTableData);
                $updateTimeTableData->id_period = $period;
                $updateTimeTableData->start_time = $startTime;
                $updateTimeTableData->end_time = $endTime;
                $updateTimeTableData->modified_by = Session::get('userId');
                $updateTimeTableData->updated_at = Carbon::now();

                $updateData = $classTimeTableSettingsRepository->update($updateTimeTableData);
            }

            $signal = 'success';
            $msg = 'Data Updated successfully!';

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        //delete timetable setting
        public function delete($id){
            $classTimeTableSettingsRepository = new ClassTimeTableSettingsRepository();

            $result = $classTimeTableSettingsRepository->delete($id);
            return $result;
        }
    }
?>
