<?php
    namespace App\Repositories;
    use App\Models\StudentLeaveManagement;
    use App\Interfaces\StudentLeaveManagementRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;
    use Carbon\Carbon;
    use Session;
    use DB;

    class StudentLeaveManagementRepository implements StudentLeaveManagementRepositoryInterface{

        public function all(){
            return StudentLeaveManagement::all();
        }

        public function store($data){
            return StudentLeaveManagement::create($data);
        }

        public function fetch($id){
            return StudentLeaveManagement::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return StudentLeaveManagement::find($id)->delete();
        }

        public function allDeleted(){
            return StudentLeaveManagement::onlyTrashed()->get();
        }

        public function restore($id){
            return StudentLeaveManagement::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return StudentLeaveManagement::onlyTrashed()->restore();
        }

        public function leaveReportData($request){

            $leave_type= $request->leaveType;

            $from_date = Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d');
            $to_date = Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d');

            DB::enableQueryLog();
            $applicationData = StudentLeaveManagement::where(function($query) use ($from_date, $to_date){
                                                    $query->where('from_date','>=',$from_date)
                                                    ->where('to_date','<=',$to_date);
                                                })
                                            ->whereIn('leave_status', $leave_type)
                                            ->get();
            // dd(\DB::getQueryLog());
            return $applicationData;
        }
    }
?>
