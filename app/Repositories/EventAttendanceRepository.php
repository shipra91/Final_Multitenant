<?php
    namespace App\Repositories;
    use App\Models\EventAttendance;
    use App\Interfaces\EventAttendanceRepositoryInterface;

    class EventAttendanceRepository implements EventAttendanceRepositoryInterface{

        public function all(){
            return EventAttendance::all();
        }

        public function store($data){
            return $eventAttendance = EventAttendance::create($data);
        }

        public function search($idAttendance){
            return EventAttendance::where('id', $idAttendance)->first();
        }


        // public function fetch($id){
        //     return $eventAttendance = EventAttendance::find($id);
        // }

        public function fetch($eventId, $recepientId){
            $attendance = EventAttendance::where('id_event', $eventId)
                                        ->where('id_recipient', $recepientId)->first();
            return $attendance;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $eventAttendance = EventAttendance::find($id)->delete();
        }
    }
