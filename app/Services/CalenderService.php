<?php
    namespace App\Services;
    
    use App\Repositories\EventRepository;
    use App\Repositories\HolidayRepository;
    use App\Repositories\StaffRepository;
    use Carbon\Carbon;
    use Session;
    use DB;

    class CalenderService {
        public function getCalenderData($request){

            $eventRepository = new EventRepository();
            $holidayRepository = new HolidayRepository();

            $eventData = $eventRepository->getEventData($request);
            $holidayData = $holidayRepository->getHolidayData($request); 
            
            $response = array();

            //event
            foreach($eventData as $index => $event){
                $data = array(
                    'id' => $event['id'],
                    'title' => $event['name'],
                    'start' => $event['start_date'],
                    'end' => $event['end_date'],
                    'color' => '#257e4a'
                );

                array_push($response, $data);
            }

            //holiday
            foreach($holidayData as $index => $event){
                $data = array(
                    'id' => $event['id'],
                    'title' => $event['title'],
                    'start' => $event['start_date'],
                    'end' => $event['end_date'],
                    'color' => '#ff9f89'
                );

                array_push($response, $data);
            }

            return $response;
        }
    }
?>