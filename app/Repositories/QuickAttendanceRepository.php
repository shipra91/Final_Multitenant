<?php
    namespace App\Repositories;
    use App\Models\Attendance;
    use App\Interfaces\QuickAttendanceRepositoryInterface;

    class QuickAttendanceRepository implements QuickAttendanceRepositoryInterface{

        public function all($allSessions){
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            return Attendance::where('id_institute', $institutionId)
                                ->where('id_academic_year', $academicYear)
                                ->get();
        }

        public function store($data){
            return $attendance = Attendance::create($data);
        }

        public function fetch($id){
            return $attendance = Attendance::find($id);
        }

        // public function update($data, $id){
        //     return Attendance::whereId($id)->update($data);
        //

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $attendance = Attendance::find($id)->delete();
        }

        public function fetchAbsentStudents($allSessions){
            $date = date('Y-m-d');
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            
            return Attendance::where('id_institute', $institutionId)
                                ->where('id_academic_year', $academicYear)
                                ->where('attendance_status', 'ABSENT')
                                ->where('held_on', $date)
                                ->get();
        }
    }
?>

