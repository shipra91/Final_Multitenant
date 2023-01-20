<?php
    namespace App\Repositories;
    use App\Models\Attendance;
    use App\Interfaces\QuickAttendanceRepositoryInterface;

    class QuickAttendanceRepository implements QuickAttendanceRepositoryInterface{

        public function all(){
            return Attendance::all();
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

        public function fetchAbsentStudents(){
            $date = date('Y-m-d');
            return Attendance::where('attendance_status', 'ABSENT')->where('held_on', $date)->get();
        }
    }
?>

