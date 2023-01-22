<?php
    namespace App\Repositories;
    use App\Models\Seminar;
    use App\Interfaces\SeminarRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class SeminarRepository implements SeminarRepositoryInterface{

        public function all($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return Seminar::where('id_institute', $institutionId)->where('id_academic', $academicYear)->get();
        }

        public function store($data){
            return $seminar = Seminar::create($data);
        }

        public function fetch($id){
            $seminar = Seminar::find($id);
            return $seminar;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $seminar = Seminar::find($id)->delete();
        }

        public function allDeleted($allSessions){
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            return Seminar::where('id_institute', $institutionId)->where('id_academic', $academicYear)->onlyTrashed()->get();
        }

        public function restore($id){
            return Seminar::withTrashed()->find($id)->restore();
        }

        public function restoreAll($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            return Seminar::where('id_institute', $institutionId)->where('id_academic', $academicYear)->onlyTrashed()->restore();
        }
    }
