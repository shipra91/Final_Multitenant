<?php
    namespace App\Repositories;

    use App\Models\Attendance;
    use App\Models\StudentMapping;
    use App\Interfaces\AttendanceRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class AttendanceRepository implements AttendanceRepositoryInterface {

        public function all(){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return Attendance::where('id_institute', $institutionId)
                            ->where('id_academic_year', $academicYear)
                            ->get();
        }

        public function store($data){
            return $attendance = Attendance::create($data);
        }

        public function search($idAttendance){
            return Attendance::where('id', $idAttendance)->first();
        }

        public function fetchAttendanceStatus($idStudent, $heldOn, $standardId, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $attendance = Attendance::where('id_institute', $institutionId)
                                    ->where('id_academic_year', $academicYear)
                                    ->where('id_standard', $standardId)
                                    ->where('id_student', $idStudent)
                                    ->where('held_on', $heldOn)
                                    ->get('attendance_status');
            return $attendance;
        }

        public function fetch($studentId, $heldOn, $standardId, $subjectId, $attendanceType, $periodSession, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            //DB::enableQueryLog();
            $attendance = Attendance::where('id_institute', $institutionId)
                                    ->where('id_academic_year', $academicYear)
                                    ->where('id_attendance_type', $attendanceType)
                                    ->where('id_standard', $standardId)
                                    ->where('id_student', $studentId)
                                    ->where('held_on', $heldOn);

            if($attendanceType === "sessionwise"){

                $attendanceQuery = $attendance->where('period_session', $periodSession);

            }else if($attendanceType === "periodwise"){

                $attendanceQuery = $attendance->where('period_session', $periodSession)->where('id_subject', $subjectId);
            }
            $attendanceQuery = $attendance->first();
            // dd(DB::getQueryLog());
            return $attendanceQuery;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $attendance = Attendance::find($id)->delete();
        }

        // public function fetchStudents($standardId){

        //     $allSessions = session()->all();
        //     $institutionId = $allSessions['institutionId'];
        //     $academicYear = $allSessions['academicYear'];

        //     \DB::enableQueryLog();
        //     $data = StudentMapping::where('tbl_student_mapping.id_standard', $standardId)
        //                 ->where('tbl_student_mapping.id_institute', $institutionId)
        //                 ->where('tbl_student_mapping.id_academic_year', $academicYear)->get();
        //     //dd(\DB::getQueryLog());
        //     return $data;
        // }

        public function fetchAttendanceDetail($request, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $standardId = $request['standard'];

            $heldOn = $request['attendance_date'];
            $heldOn = Carbon::createFromFormat('d/m/Y', $heldOn)->format('Y-m-d');
            //\DB::enableQueryLog();
            $attendanceDetails = Attendance::Select('tbl_attendance.*', 'tbl_student.*')
                    ->join('tbl_student', 'tbl_student.id', '=', 'tbl_attendance.id_student')
                    ->where('tbl_attendance.id_standard', $standardId)
                    ->where('tbl_attendance.held_on', $heldOn)
                    ->where('tbl_attendance.id_institute', $institutionId)
                    ->where('tbl_attendance.id_academic_year', $academicYear)
                    ->groupBy('tbl_attendance.id_student')
                    ->get();
            //dd(\DB::getQueryLog());

            return $attendanceDetails;
        }

        public function fetchWorkingDays($studentUid, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            //DB::enableQueryLog();
            $workingDays = Attendance::where('id_institute', $institutionId)
                                    ->where('id_academic_year', $academicYear)
                                    ->where('id_student', $studentUid)
                                    ->where('id_institute', $institutionId)
                                    ->where('id_academic_year', $academicYear)->count();
            //dd(\DB::getQueryLog());
            return $workingDays;
        }

        public function fetchPresentDays($studentUid, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            //DB::enableQueryLog();
            $presentDays = Attendance::where('id_student', $studentUid)
                                    ->where('id_institute', $institutionId)
                                    ->where('id_academic_year', $academicYear)
                                    ->where('attendance_status', 'PRESENT')->count();
            //dd(\DB::getQueryLog());
            return $presentDays;
        }

        public function allPeriodAttendanceData($standardId, $idStudent, $date, $idPeriodSession, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $attendanceData = Attendance::where('id_student', $idStudent)
                                    ->where('id_standard', $standardId)
                                    ->where('id_institute', $institutionId)
                                    ->where('id_academic_year', $academicYear)
                                    ->where('period_session', $idPeriodSession)
                                    ->where('held_on', $date)
                                    ->first();
            return $attendanceData;
        }

        public function allDayAttendanceData($standardId, $idStudent, $date, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $attendanceData = Attendance::where('id_student', $idStudent)
                                    ->where('id_standard', $standardId)
                                    ->where('id_institute', $institutionId)
                                    ->where('id_academic_year', $academicYear)
                                    ->where('held_on', $date)
                                    ->first();
            return $attendanceData;
        }

        public function allPeriodAbsentAttendanceData($standardId, $idStudent, $date, $idPeriodSession){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $attendanceData = Attendance::where('id_student', $idStudent)
                                    ->where('id_standard', $standardId)
                                    ->where('id_institute', $institutionId)
                                    ->where('id_academic_year', $academicYear)
                                    ->where('period_session', $idPeriodSession)
                                    ->where('held_on', $date)
                                    ->first();
            return $attendanceData;
        }

        public function allDayAbsentAttendanceData($standardId, $idStudent, $date){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $attendanceData = Attendance::where('id_student', $idStudent)
                                    ->where('id_standard', $standardId)
                                    ->where('id_institute', $institutionId)
                                    ->where('id_academic_year', $academicYear)
                                    ->where('held_on', $date)
                                    ->first();
            return $attendanceData;
        }

        public function checkAttendanceForStandard($idStandard, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            return Attendance::where('id_institute', $institutionId)
                            ->where('id_academic_year', $academicYear)
                            ->where('id_standard', $idStandard)
                            ->first();
        }
    }

    ?>
