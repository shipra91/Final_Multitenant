<?php
    namespace App\Repositories;
    use App\Models\StandardSubjectStaffMapping;
    use App\Interfaces\StandardSubjectStaffMappingRepositoryInterface;
    use DB;
    use Session;

    class StandardSubjectStaffMappingRepository implements StandardSubjectStaffMappingRepositoryInterface {

        // public function all(){
        //     return StandardSubjectStaffMapping::all();
        // }

        public function all($staffId){
            //DB::enableQueryLog();
            return $allSubjects = StandardSubjectStaffMapping::where('id_staff', $staffId)->get();
            // dd(DB::getQueryLog());
        }

        public function store($data){
            return $standardSubjectStaffMapping = StandardSubjectStaffMapping::create($data);
        }

        public function fetch($id){
            return $standardSubjectStaffMapping = StandardSubjectStaffMapping::find($id);
        }

        public function update($data, $id){
            return StandardSubjectStaffMapping::whereId($id)->update($data);
        }

        public function delete($subjectId, $standardId){

            $allSessions = session()->all();
            $idInstitution = $allSessions['institutionId'];
            $idAcademic = $allSessions['academicYear'];

            return StandardSubjectStaffMapping::where('id_institute', $idInstitution)
                                                ->where('id_academic_year', $idAcademic)
                                                ->where('id_subject', $subjectId)
                                                ->where('id_standard', $standardId)->delete();
        }

        public function getStaffs($subjectId, $standardId){

            $allSessions = session()->all();
            $idInstitution = $allSessions['institutionId'];
            $idAcademic = $allSessions['academicYear'];

            return StandardSubjectStaffMapping::where('id_institute', $idInstitution)
                                                ->where('id_academic_year', $idAcademic)
                                                ->where('id_subject', $subjectId)
                                                ->where('id_standard', $standardId)
                                                ->groupBy('id_staff')->get(['id_staff']);
        }

        public function getStandardMappedWithStaff($idStaff){

            $allSessions = session()->all();
            $idInstitution = $allSessions['institutionId'];
            $idAcademic = $allSessions['academicYear'];

            return StandardSubjectStaffMapping::join('tbl_institution_standard', 'tbl_institution_standard.id', '=', 'tbl_standard_subject_staff_mapping.id_standard')
                                                ->where('tbl_standard_subject_staff_mapping.id_institute', $idInstitution)
                                                ->where('tbl_standard_subject_staff_mapping.id_academic_year', $idAcademic)
                                                ->where('tbl_standard_subject_staff_mapping.id_staff', $idStaff)
                                                ->select('tbl_institution_standard.*')
                                                ->groupBy('tbl_standard_subject_staff_mapping.id_standard')->get();
        }

        public function fetchStandardStaffSubjects($idStandard, $idStaff){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            // DB::enableQueryLog();
            return StandardSubjectStaffMapping::join('tbl_institution_subject', 'tbl_institution_subject.id', '=', 'tbl_standard_subject_staff_mapping.id_subject')
                                                ->leftJoin('tbl_standard_subject', 'tbl_institution_subject.id', '=', 'tbl_standard_subject.id_institution_subject')
                                                ->where('tbl_standard_subject_staff_mapping.id_standard', $idStandard)
                                                ->where('tbl_standard_subject_staff_mapping.id_institute', $institutionId)
                                                ->where('tbl_standard_subject_staff_mapping.id_academic_year', $academicId)
                                                ->where('tbl_standard_subject_staff_mapping.id_staff', $idStaff)
                                                ->whereNull('tbl_institution_subject.deleted_at')
                                                ->whereNull('tbl_standard_subject.deleted_at')
                                                ->select(['tbl_standard_subject.*', 'tbl_institution_subject.*'])                                                
                                                ->groupBy('tbl_standard_subject.id_institution_subject')
                                                ->get();
            // dd(DB::getQueryLog());
        }

        // Get staff based on standard and subject
        public function getStaffOnStandardAndSubject($standardId, $subjectids){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            DB::enableQueryLog();
            $staffDetails = StandardSubjectStaffMapping::join('tbl_staff', 'tbl_staff.id', '=', 'tbl_standard_subject_staff_mapping.id_staff')
                                ->join('tbl_institution_subject', 'tbl_institution_subject.id', '=', 'tbl_standard_subject_staff_mapping.id_subject')
                                ->where('tbl_standard_subject_staff_mapping.id_standard',$standardId)
                                ->whereIn('tbl_standard_subject_staff_mapping.id_subject',$subjectids)
                                ->where('tbl_standard_subject_staff_mapping.id_institute',$institutionId)
                                ->where('tbl_standard_subject_staff_mapping.id_academic_year',$academicId)
                                ->select('tbl_staff.*', 'tbl_standard_subject_staff_mapping.id_staff', 'tbl_institution_subject.display_name', 'tbl_institution_subject.subject_type')
                                ->get();
            // dd(\DB::getQueryLog());
            return $staffDetails;
        }

        public function fetchStaffOnStandardAndSubject($standardId, $subjectid){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            DB::enableQueryLog();
            $staffDetails = StandardSubjectStaffMapping::join('tbl_staff', 'tbl_staff.id', '=', 'tbl_standard_subject_staff_mapping.id_staff')
                                ->join('tbl_institution_subject', 'tbl_institution_subject.id', '=', 'tbl_standard_subject_staff_mapping.id_subject')
                                ->where('tbl_standard_subject_staff_mapping.id_standard',$standardId)
                                ->where('tbl_standard_subject_staff_mapping.id_subject',$subjectid)
                                ->where('tbl_standard_subject_staff_mapping.id_institute',$institutionId)
                                ->where('tbl_standard_subject_staff_mapping.id_academic_year',$academicId)
                                ->select('tbl_staff.*', 'tbl_standard_subject_staff_mapping.id_staff', 'tbl_institution_subject.display_name', 'tbl_institution_subject.subject_type')
                                ->get();
            // dd(\DB::getQueryLog());
            return $staffDetails;
        }

        public function checkSubjectStaffs($subjectId, $staffId, $StandardId){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return $data = StandardSubjectStaffMapping::where('id_institute', $institutionId)
                                                ->where('id_academic_year', $academicId)
                                                ->where('id_standard', $StandardId)
                                                ->where('id_subject', $subjectId)
                                                ->where('id_staff', $staffId)->first();
        }

        public function fetchIfMapped($idStandard){
            
            $allSessions = session()->all();
            $idInstitution = $allSessions['institutionId'];
            $idAcademic = $allSessions['academicYear'];
         
            return StandardSubjectStaffMapping::where('id_institute', $idInstitution)
            ->where('id_academic_year', $idAcademic)
            ->where('id_standard', $idStandard)
            ->get();  
        }
    }