<?php
    namespace App\Repositories;

    use App\Models\AttendanceSession;
    use App\Interfaces\AttendanceSessionRepositoryInterface;

    class AttendanceSessionRepository implements AttendanceSessionRepositoryInterface{

        public function all($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return AttendanceSession::where('id_institute', $institutionId)->where('id_academic_year', $academicId)->get();
        }

        public function store($data){
            return $data = AttendanceSession::create($data);
        }

        public function fetch($id){
            return $data = AttendanceSession::find($id);
        }

        public function update($data, $id){
            return AttendanceSession::whereId($id)->update($data);
        }

        public function delete($id){
            return $data = AttendanceSession::find($id)->delete();
        }

        public function allDeleted($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return AttendanceSession::where('id_institute', $institutionId)
                                    ->where('id_academic_year', $academicId)
                                    ->onlyTrashed()
                                    ->get();
        }

        public function restore($id){
            return AttendanceSession::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return AttendanceSession::onlyTrashed()->restore();
        }
    }

