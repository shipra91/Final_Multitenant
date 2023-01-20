<?php
    namespace App\Repositories;
    use App\Models\StaffAttendance;
    use App\Interfaces\StaffAttendanceRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class StaffAttendanceRepository implements StaffAttendanceRepositoryInterface{

        public function all(){
            return StaffAttendance::all();
        }

        public function store($data){
            return StaffAttendance::create($data);
        }

        public function search($idAttendance){
            return StaffAttendance::where('id', $idAttendance)->first();
        }

        public function fetch($staffId, $heldOn, $idInstitution, $academicYear){

            DB::enableQueryLog();
            $staffAttendance = StaffAttendance::where('id_staff', $staffId)->where('held_on', $heldOn)->where('id_institute', $idInstitution)->where('id_academic_year', $academicYear)->first();
            // dd(DB::getQueryLog());
            return $staffAttendance;
        }

        public function update($data){
            return $data->save();
        }

        public function fetchAttendanceDetail($request){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $heldOn = $request['attendance_date'];
            $heldOn = Carbon::createFromFormat('d/m/Y', $heldOn)->format('Y-m-d');
            \DB::enableQueryLog();
            $attendanceDetails = StaffAttendance::Select('tbl_staff_attendances.*', 'tbl_staff.*')
                                        ->join('tbl_staff', 'tbl_staff.id', '=', 'tbl_staff_attendances.id_staff')
                                        ->where('tbl_staff_attendances.held_on', $heldOn)
                                        ->where('tbl_staff_attendances.id_institute', $institutionId)
                                        ->where('tbl_staff_attendances.id_academic_year', $academicYear)->get();
            // dd(\DB::getQueryLog());

            return $attendanceDetails;
        }

        public function fetchWorkingDays($idStaff){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            \DB::enableQueryLog();
            $workingDays = StaffAttendance::where('id_staff', $idStaff)
                                        ->where('id_institute', $institutionId)
                                        ->where('id_academic_year', $academicYear)->count();
            //dd(\DB::getQueryLog());
            return $workingDays;
        }

        public function fetchPresentDays($idStaff){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            \DB::enableQueryLog();
            $presentDays = StaffAttendance::where('id_staff', $idStaff)
                                        ->where('id_institute', $institutionId)
                                        ->where('id_academic_year', $academicYear)
                                        ->where('status', 'present')->count();
            //dd(\DB::getQueryLog());
            return $presentDays;
        }

        public function delete($id){
            return StaffAttendance::find($id)->delete();
        }
    }
?>
