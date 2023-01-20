<?php
    namespace App\Repositories;
    use App\Models\EventApplicableTo;
    use App\Interfaces\EventApplicableToRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class EventApplicableToRepository implements EventApplicableToRepositoryInterface{

        public function all(){
            return EventApplicableTo::all();
        }

        public function store($data){
            return $eventApplicableTo = EventApplicableTo::create($data);
        }

        public function fetch($id){
            return $eventApplicableTo = EventApplicableTo::find($id);
        }

        public function update($data){
            return $data->save();
        }

        // public function delete($id){
        //     return $eventApplicableTo = EventApplicableTo::find($id)->delete();
        // }

        public function delete($idEvent){
            return $eventApplicableTo = EventApplicableTo::where('id_event', $idEvent)->delete();
        }

        public function allEventCategory($idEvent, $recepientType){
            return eventApplicableTo::where('id_event', $idEvent)
                                        ->where('recipient_type', $recepientType)
                                        ->select('id_staff_category')
                                        ->groupBy('id_staff_category')->get();
        }

        public function allEventSubCategory($idEvent, $recepientType){
            return eventApplicableTo::where('id_event', $idEvent)
                                        ->where('recipient_type', $recepientType)
                                        ->select('id_staff_subcategory')
                                        ->groupBy('id_staff_subcategory')->get();
        }

        public function allEventStandards($idEvent, $recepientType){
            return eventApplicableTo::where('id_event', $idEvent)
                                        ->where('recipient_type', $recepientType)
                                        ->select('id_standard')
                                        ->groupBy('id_standard')->get();
        }

        public function allEventSubjects($idEvent, $recepientType){
            return eventApplicableTo::where('id_event', $idEvent)
                                        ->where('recipient_type', $recepientType)
                                        ->select('id_subject')
                                        ->groupBy('id_subject')->get();
        }
    }
