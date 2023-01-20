<?php
    namespace App\Repositories;

    use App\Models\PracticalAttendance;
    use App\Interfaces\PracticalAttendanceRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class PracticalAttendanceRepository implements PracticalAttendanceRepositoryInterface {

        public function all(){
            return PracticalAttendance::all();
        }

        public function store($data){
            return $data = PracticalAttendance::create($data);
        }

        public function search($idAttendance){
            return PracticalAttendance::where('id', $idAttendance)->first();
        }

        // public function fetch($id){
        //     return $data = PracticalAttendance::find($id);
        // }

        public function fetch($standardId, $subjectId, $studentId, $periodId, $batchId, $heldOn){
            DB::enableQueryLog();
            $attendance = PracticalAttendance::where('id_standard', $standardId)
                                        ->where('id_subject', $subjectId)
                                        ->where('id_student', $studentId)
                                        ->where('id_period', $periodId)
                                        ->where('id_batch', $batchId)
                                        ->where('held_on', $heldOn)->first();
            // dd(DB::getQueryLog());
            return $attendance;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $data = PracticalAttendance::find($id)->delete();
        }
    }
?>
