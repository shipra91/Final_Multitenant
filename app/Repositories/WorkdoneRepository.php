<?php
    namespace App\Repositories;
    use App\Models\Workdone;
    use App\Interfaces\WorkdoneRepositoryInterface;
    use Session;

    class WorkdoneRepository implements WorkdoneRepositoryInterface{

        public function all(){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return Workdone::where('id_institute', $institutionId)
              ->where('id_academic', $academicId)->orderBy('created_at', 'ASC')->get();
        }

        public function store($data){
            return $workdone = Workdone::create($data);
        }

        public function fetch($id){
            return $workdone = Workdone::find($id);
        } 
        public function fetchWorkdoneUsingStaff($idStaff, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return $workdone = Workdone::where('id_institute', $institutionId)
            ->where('id_academic', $academicId)->where('id_staff', $idStaff)->get();
        } 

        public function fetchWorkdoneByStandard($idStandard, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return $workdone = Workdone::where('id_institute', $institutionId)
                                            ->where('id_academic', $academicId)
                                            ->where('id_standard', $idStandard)
                                            ->get();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $workdone = Workdone::find($id)->delete();
        }

        public function allDeleted($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return Workdone::where('id_institute', $institutionId)
                            ->where('id_academic', $academicId)
                            ->onlyTrashed()->get();
        }        

        public function restore($id){
            return Workdone::withTrashed()->find($id)->restore();
        }

        public function restoreAll($allSessions){
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return Workdone::where('id_institute', $institutionId)
                            ->where('id_academic', $academicId)
                            ->onlyTrashed()->restore();
        }
    }