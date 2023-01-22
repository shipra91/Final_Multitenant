<?php
    namespace App\Repositories;

    use App\Models\InstitutionSubject;
    use App\Interfaces\InstitutionSubjectRepositoryInterface;
    use Session;
    use DB;

    class InstitutionSubjectRepository implements InstitutionSubjectRepositoryInterface {

        public function all($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return InstitutionSubject::where('id_institute', $institutionId)
                        // ->where('id_academic_year', $academicId)
                        ->get();
        }

        public function store($data){
            return InstitutionSubject::create($data);
        }

        public function fetch($subjectType, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            // DB::enableQueryLog();
            return InstitutionSubject::join('tbl_subject', 'tbl_subject.id', '=', 'tbl_institution_subject.id_subject')
                                    ->where('tbl_institution_subject.id_institute', $institutionId)
                                    // ->where('tbl_institution_subject.id_academic_year', $academicId)
                                    ->where('tbl_subject.id_type', $subjectType)
                                    ->get(['tbl_subject.*', 'tbl_institution_subject.*']);
            // dd(DB::getQueryLog());
        }

        public function find($id){
            $institutionSubject = InstitutionSubject::join('tbl_subject', 'tbl_subject.id', '=', 'tbl_institution_subject.id_subject')
                    ->join('tbl_subject_type', 'tbl_subject_type.id', '=', 'tbl_subject.id_type')
                    ->where('tbl_institution_subject.id', $id)
                    ->select('tbl_institution_subject.*', 'tbl_subject.name', 'tbl_subject.id_type', 'tbl_subject_type.label')
                    ->first();
            return $institutionSubject;
        }

        public function findCount($subjectId, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            // DB::enableQueryLog();
            return InstitutionSubject::where('id_institute', $institutionId)
                        // ->where('id_academic_year', $academicId)
                        ->where('id_subject', $subjectId)
                        ->get();
            // dd(DB::getQueryLog());
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return InstitutionSubject::delete($id);
        }

        public function updateInstitutionSubject($data, $id){
            return InstitutionSubject::whereId($id)->update($data);
        }

        public function fetchInstitutionAttendanceSubject($attendanceType, $allSessions){
            // dd($subjectType);
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            // DB::enableQueryLog();

            return InstitutionSubject::Join('tbl_standard_subject', 'tbl_standard_subject.id_institution_subject', '=', 'tbl_institution_subject.id')
                                    ->leftJoin('tbl_institution_standard', 'tbl_institution_standard.id', '=', 'tbl_standard_subject.id_standard')
                                    ->leftJoin('tbl_attendance_settings', 'tbl_attendance_settings.id_standard', '=', 'tbl_institution_standard.id')
                                    ->where('tbl_institution_subject.id_institute', $institutionId)
                                    // ->where('tbl_institution_subject.id_academic_year', $academicId)
                                    ->where('tbl_attendance_settings.attendance_type', $attendanceType)
                                    ->get(['tbl_institution_subject.*']);
            // dd(DB::getQueryLog());
        }

        public function fetchPracticalSubjects($subjectType, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            //DB::enableQueryLog();
            return InstitutionSubject::join('tbl_subject', 'tbl_subject.id', '=', 'tbl_institution_subject.id_subject')
                                    ->where('tbl_institution_subject.id_institute', $institutionId)
                                    // ->where('tbl_institution_subject.id_academic_year', $academicId)
                                    ->where('tbl_institution_subject.subject_type', $subjectType)
                                    ->get(['tbl_subject.*', 'tbl_institution_subject.*']);
            //dd(DB::getQueryLog());
        }

        public function fetchSubjectDetail($masterSubjectId, $allSessions){
            // dd($subjectType);
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            // DB::enableQueryLog();
            $subjectData = InstitutionSubject::join('tbl_subject', 'tbl_subject.id', '=', 'tbl_institution_subject.id_subject')
                        ->join('tbl_exam_timetable', 'tbl_exam_timetable.id_institution_subject', '=', 'tbl_institution_subject.id')
                        ->where('id_institute', $institutionId)
                        ->where('tbl_institution_subject.id_subject', $masterSubjectId)
                        ->select('tbl_institution_subject.*', 'tbl_exam_timetable.max_marks')
                        ->get();
            // dd(DB::getQueryLog());
            return $subjectData;
        }

        public function getInstitutionSubjectId($subjectDetails, $allSessions) {

            $subjectDisplayName = $subjectDetails[0]; 
            $subjectType = $subjectDetails[1];

            $academicYear  = $allSessions['academicYear'];
            $institutionId = $allSessions['institutionId'];

            return InstitutionSubject::where('id_institute', $institutionId)
            ->where('id_academic_year', $academicYear)
            ->where('display_name', $subjectDisplayName)
            ->where('subject_type', $subjectType)
            ->first();
        }

        public function getInstitutionSubjectDetails($masterSubjectId, $allSessions) {

            $academicYear  = $allSessions['academicYear'];
            $institutionId = $allSessions['institutionId'];

            return InstitutionSubject::where('id_institute', $institutionId)
            ->where('id_academic_year', $academicYear)
            ->where('id_subject', $masterSubjectId)
            ->first();
        }
    }
?>
