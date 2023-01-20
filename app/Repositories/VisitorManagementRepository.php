<?php
    namespace App\Repositories;
    use App\Models\VisitorManagement;
    use App\Interfaces\VisitorManagementRepositoryInterface;
    use Carbon\Carbon;
    use Session;
    use DB;

    class VisitorManagementRepository implements VisitorManagementRepositoryInterface {

        public function all($request){

            DB::enableQueryLog();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $toDays = date('Y-m-d');
            $weekOfdays = array();
            $weekOfdays[1] = $toDays;
            for($i = 1; $i < 7; $i++){
                $date = date('Y-m-d', strtotime('+'.$i.' day', strtotime($toDays)));
                $weekOfdays[] = date('Y-m-d', strtotime($date));
            }

            $visitorData = VisitorManagement::where('id_institute', $institutionId)->where('id_academic_year', $academicYear);

            if(isset($request['visitorType'])){
                $visitorData = $visitorData->where('type', 'like', '%'.$request['visitorType'].'%');
            }

            if(isset($request['todayOrWeeklyVisitor'])){

                if($request['todayOrWeeklyVisitor'] === "WEEKLY"){
                    // $visitorData = $visitorData->whereIn(DATE_FORMAT(visiting_datetime, "%Y-%m-%d"), $weekOfdays);

                    $visitorData = $visitorData->whereIn( DB::raw("DATE(visiting_datetime)"),$weekOfdays);


                }else{
                    $visitorData = $visitorData->whereDate('visiting_datetime', $toDays);
                }
            }

            $visitorData = $visitorData->get();
            // dd(DB::getQueryLog());
            return $visitorData;
        }

        public function store($data){
            return $VisitorManagement = VisitorManagement::create($data);
        }

        public function fetch($id){
            return $VisitorManagement = VisitorManagement::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $VisitorManagement = VisitorManagement::find($id)->delete();
        }

        public function visitorReportData($request){

            $status_type= $request->status_type;
            $visitorType= $request->visitorType;

            $from_date = Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d');
            $to_date = Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d');

            DB::enableQueryLog();
            $visitorData = VisitorManagement::where('type', $visitorType)
                                            ->whereBetween('visiting_datetime', [$from_date, $to_date])
                                            ->whereIn('visiting_status', $status_type)
                                            ->get();
            // dd(\DB::getQueryLog());
            return $visitorData;
        }

        public function allDeleted(){
            return VisitorManagement::onlyTrashed()->get();
        }

        public function restore($id){
            return VisitorManagement::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return VisitorManagement::onlyTrashed()->restore();
        }
    }
?>
