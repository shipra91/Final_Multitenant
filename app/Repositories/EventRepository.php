<?php
    namespace App\Repositories;
    use App\Models\Event;
    use App\Models\StandardSubject;
    use App\Interfaces\EventRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class EventRepository implements EventRepositoryInterface{

        public function all($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return Event::where('id_institute', $institutionId)
                        ->where('id_academic', $academicId)
                        ->get();
        }

        public function store($data){
            return $event = Event::create($data);
        }

        public function search($idAttendance){
            return Event::where('id', $idAttendance)->first();
        }

        public function fetch($id){
            $event = Event::find($id);
            return $event;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $event = Event::find($id)->delete();
        }

        public function allDeleted($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            
            return Event::where('id_institute', $institutionId)
                        ->where('id_academic', $academicId)
                        ->onlyTrashed()
                        ->get();
        }

        public function restore($id){
            return Event::withTrashed()->find($id)->restore();
        }

        public function restoreAll($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return Event::where('id_institute', $institutionId)
                        ->where('id_academic', $academicId)
                        ->onlyTrashed()
                        ->restore();
        }

        public function fetchStandardSubjects($idStandard, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            //\DB::enableQueryLog();
            $data = StandardSubject::leftJoin('tbl_institution_subject', 'tbl_institution_subject.id', '=', 'tbl_standard_subject.id_institution_subject')
                            ->whereIn('tbl_standard_subject.id_standard', $idStandard)
                            ->where('tbl_standard_subject.id_institute', $institutionId)
                            ->where('tbl_standard_subject.id_academic_year', $academicId)
                            ->select('tbl_standard_subject.*', 'tbl_institution_subject.*')->get();
            // dd(\DB::getQueryLog());
            return $data;
        }

        //FUNCTION TO CALENDER DATA
        public function getEventData($request, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $data = Event::whereDate('start_date', '>=', $request->start)
                        ->whereDate('end_date', '<=', $request->end)
                        ->where('id_institute', $institutionId)
                        ->where('id_academic', $academicId)
                        ->get();

            return $data;
        }
    }
