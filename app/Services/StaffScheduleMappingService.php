<?php
    namespace App\Services;
    use App\Models\StaffScheduleMapping;
    use App\Repositories\StaffScheduleMappingRepository;
    use Session;

    class StaffScheduleMappingService {

        // Get All Staff Schedule
        public function getData($staffId){
            $staffScheduleMappingRepository = new StaffScheduleMappingRepository();
            $daysArray = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

            foreach ($daysArray as $key => $day){
                $dataArray[$day] = array();
                $dataArray[$day] = $staffScheduleMappingRepository->all($staffId, $day);
            }
            return $dataArray;
        }

        // Insert And Update Staff Schedule
        public function add($staffScheduleData){
            $staffScheduleMappingRepository = new StaffScheduleMappingRepository();

            $daysArray = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            $count = 0;
            foreach ($daysArray as $key => $day){

                $fromTime = "fromTime_".$day;
                $toTime = "toTime_".$day;


                if($staffScheduleData->$fromTime[0] != ''){

                    foreach($staffScheduleData->$fromTime as $index => $dayFromTime){

                        if($dayFromTime !='' AND $staffScheduleData->$toTime[$index] !=''){

                            $schedule = "scheduleId_".$day;
                            // dd($staffScheduleData->$toTime);
                            if($staffScheduleData->$schedule[$index] == ''){

                                $data = array(
                                    'id_staff' => $staffScheduleData->staffId,
                                    'id_academic_year' => $staffScheduleData->id_academic,
                                    'day' => $day,
                                    'start_time' => $dayFromTime,
                                    'end_time' => $staffScheduleData->$toTime[$index],
                                    'created_by' => Session::get('userId'),
                                    'modified_by' => '',
                                );

                                $storeData = $staffScheduleMappingRepository->store($data);
                                if($storeData){
                                    $count++;
                                }

                            }else{

                                $scheduleId = $staffScheduleData->$schedule[$index];

                                $data = $staffScheduleMappingRepository->fetch($scheduleId);

                                $data->start_time = $dayFromTime;
                                $data->end_time = $staffScheduleData->$toTime[$index];
                                $data->modified_by = Session::get('userId');

                                $storeData = $staffScheduleMappingRepository->update($data);
                                if($storeData){
                                    $count++;
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
    }
