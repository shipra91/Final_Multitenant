<?php
    namespace App\Repositories;
    use App\Models\Attendance;
    use App\Interfaces\AttendanceReportRepositoryInterface;
    use App\Repositories\AttendanceRepository;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class AttendanceReportRepository implements AttendanceReportRepositoryInterface{

        public function all(){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return Attendance::where('');
        }

        public function fetch($id){

        }

        public function store($data){

        }

        public function update($id){

        }

        public function delete($id){

        }

    }
?>