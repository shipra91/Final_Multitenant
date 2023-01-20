<?php
    namespace App\Repositories;
    use App\Models\StaffSubjectMapping;
    use App\Interfaces\StaffSubjectMappingRepositoryInterface;
    use Session;
    use DB;

    class StaffSubjectMappingRepository implements StaffSubjectMappingRepositoryInterface{

        // public function all(){
        //     return StaffSubjectMapping::all();
        // }

        public function all($staffId){
            //DB::enableQueryLog();
            return $allSubjects = StaffSubjectMapping::where('id_staff', $staffId)->get();
            // dd(DB::getQueryLog());
        }

        public function allStaffs($subjectId, $allSessions){

            //DB::enableQueryLog();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $allSubjects = StaffSubjectMapping::join('tbl_staff', 'tbl_staff.id', '=', 'tbl_staff_subject_mapping.id_staff')
                                                ->where('tbl_staff_subject_mapping.id_subject', $subjectId)
                                                ->where('tbl_staff.id_institute', $institutionId)
                                                ->where('tbl_staff.id_academic_year', $academicId)
                                                ->select('tbl_staff.*')->get();
            // dd(DB::getQueryLog());
            return $allSubjects;
        }

        public function store($data){
            return $staffSubjectMapping = StaffSubjectMapping::create($data);
        }

        public function fetch($id){
            return $staffSubjectMapping = StaffSubjectMapping::find($id);
        }

        public function update($data, $id){
            return StaffSubjectMapping::whereId($id)->update($data);
        }

        public function delete($idStaff){
            return $staffSubjectMapping = StaffSubjectMapping::where('id_staff', $idStaff)->delete();
        }

        public function fetchSubjectStaffs($subjectId){

            return $allSubjectStaffs = StaffSubjectMapping::where('id_subject', $subjectId)->get(['id_staff']);
            
        }
    }
