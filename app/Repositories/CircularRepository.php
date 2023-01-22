<?php
    namespace App\Repositories;
    use App\Models\Circular;
    use App\Interfaces\CircularRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class CircularRepository implements CircularRepositoryInterface{

        public function all($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return Circular::where('id_institute', $institutionId)
                            ->where('id_academic', $academicYear)
                            ->get();
        }

        public function store($data){
            return $circular = Circular::create($data);
        }

        public function fetch($id){
            $circular = Circular::find($id);
            return $circular;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $circular = Circular::find($id)->delete();
        }

        public function allDeleted($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return Circular::where('id_institute', $institutionId)
                            ->where('id_academic', $academicYear)
                            ->onlyTrashed()
                            ->get();
        }        

        public function restore($id){
            return Circular::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return Circular::onlyTrashed()->restore();
        }

        public function getRecipientCirculars($idUser, $institutionId, $academicYear){
            return Circular::join('tbl_circular_recipient', 'tbl_circular.id', '=', 'tbl_circular_recipient.id_circular')
                                    ->where('id_institute', $institutionId)
                                    ->where('id_academic', $academicYear)
                                    ->where('id_recipient', $idUser)
                                    ->get();
        }
    }
