<?php
    namespace App\Repositories;
    use App\Models\EventRecipient;
    use App\Interfaces\EventRecipientRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class EventRecipientRepository implements EventRecipientRepositoryInterface{

        public function all(){
            return EventRecipient::all();
        }

        public function store($data){
            return $eventRecipient = EventRecipient::create($data);
        }

        public function fetch($id){
            return $eventRecipient = EventRecipient::find($id);
        }

        public function update($data){
            return $data->save();
        }

        // public function delete($id){
        //     return $eventRecipient = EventRecipient::find($id)->delete();
        // }

        public function delete($idEvent){
            return $eventRecipient = EventRecipient::where('id_event', $idEvent)->delete();
        }

        public function eventRecepientType($idEvent){
            return EventRecipient::where('id_event', $idEvent)
                                ->groupBy('recipient_type')->get();
        }

        public function eventRecepients($idEvent, $recepientType){
            return EventRecipient::where('id_event', $idEvent)
                                ->where('recipient_type', $recepientType)->get();
        }

        // Get event recipient
        public function getEventRecipient($eventId){
            //\DB::enableQueryLog();
            $recipients = EventRecipient::where('id_event', $eventId)->get();
            return $recipients;
            // dd(DB::getQueryLog());
        }
    }
