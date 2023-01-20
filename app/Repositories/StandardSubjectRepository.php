<?php
    namespace App\Repositories;
    use App\Models\StandardSubject;
    use App\Interfaces\StandardSubjectRepositoryInterface;
    use Session;
    use DB;

    class StandardSubjectRepository implements StandardSubjectRepositoryInterface {

        public function all($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return StandardSubject::where('id_institute', $institutionId)
                                    ->where('id_academic_year', $academicId)
                                    ->get();
        }

        public function store($data){
            //DB::enableQueryLog();
            return StandardSubject::create($data);
            //dd(DB::getQueryLog());
        }

        public function fetch($idStandard, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return StandardSubject::where('id_institute', $institutionId)
                                    ->where('id_academic_year', $academicId)
                                    ->where('id_standard', $idStandard)
                                    ->get();
        }

        public function fetchSubjectStandards($idSubject, $attendanceType, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            //DB::enableQueryLog();
            $data = StandardSubject::join('tbl_attendance_settings', 'tbl_attendance_settings.id_standard', '=', 'tbl_standard_subject.id_standard')
                                    ->where('id_institute', $institutionId)
                                    ->where('id_academic_year', $academicId)
                                    ->where('id_institution_subject', $idSubject)
                                    ->where('attendance_type', $attendanceType)
                                    ->get();
            //dd(DB::getQueryLog());
            return $data;
        }

        public function fetchStandardSubjects($idStandard, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            DB::enableQueryLog();
            $data = StandardSubject::join('tbl_institution_subject', 'tbl_institution_subject.id', '=', 'tbl_standard_subject.id_institution_subject')
                                ->where('tbl_standard_subject.id_standard', $idStandard)
                                ->where('tbl_standard_subject.id_institute', $institutionId)
                                ->where('tbl_standard_subject.id_academic_year', $academicId)
                                ->select('tbl_standard_subject.*', 'tbl_institution_subject.*')
                                ->get();
            // dd(DB::getQueryLog());
            return $data;
        }

        public function getStandardsSubject($idStandards, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return StandardSubject::join('tbl_institution_subject', 'tbl_institution_subject.id', '=', 'tbl_standard_subject.id_institution_subject')
                                    ->whereIn('tbl_standard_subject.id_standard', $idStandards)
                                    ->where('tbl_standard_subject.id_institute', $institutionId)
                                    ->where('tbl_standard_subject.id_academic_year', $academicId)
                                    ->select(['tbl_institution_subject.*'])
                                    ->get();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($idStandard, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return StandardSubject::where('id_standard', $idStandard)->where('id_institute', $institutionId)
            ->where('id_academic_year', $academicId)->delete();
        }

        // public function fetchStandardSubject($idInstitutionStandard){
        //     return StandardSubject::where('id_standard', $idInstitutionStandard)->get();
        // }

        public function updateStandardSubject($data, $id){
            return StandardSubject::whereId($id)->update($data);
        }

        public function findStandardSubject($idStandard, $idSubject, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return StandardSubject::join('tbl_institution_subject', 'tbl_institution_subject.id', '=', 'tbl_standard_subject.id_institution_subject')
                                    ->where('tbl_standard_subject.id_standard', $idStandard)
                                    ->where('tbl_standard_subject.id_institution_subject', $idSubject)
                                    ->where('tbl_standard_subject.id_institute', $institutionId)
                                    ->where('tbl_standard_subject.id_academic_year', $academicId)
                                    ->first();
        }

        public function fetchSubjectBelongsToStandard($idStandard, $idSubject, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return StandardSubject::where('id_standard', $idStandard)
                                    ->where('id_institute', $institutionId)
                                    ->where('id_academic_year', $academicId)
                                    ->where('id_institution_subject', $idSubject)
                                    ->first();
        }

        public function getStandardsSubjectDetails($idStandard, $idSubject, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return StandardSubject::join('tbl_institution_subject', 'tbl_institution_subject.id', '=', 'tbl_standard_subject.id_institution_subject')
                                    ->where('tbl_standard_subject.id_standard', $idStandard)
                                    ->where('tbl_institution_subject.id_subject', $idSubject)
                                    ->where('tbl_standard_subject.id_institute', $institutionId)
                                    ->where('tbl_standard_subject.id_academic_year', $academicId)
                                    ->first();
        }

        public function getInstituteSubjectIds($idStandard, $idSubject, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return StandardSubject::join('tbl_institution_subject', 'tbl_institution_subject.id', '=', 'tbl_standard_subject.id_institution_subject')
                                    ->where('tbl_standard_subject.id_standard', $idStandard)
                                    ->where('tbl_institution_subject.id_subject', $idSubject)
                                    ->where('tbl_standard_subject.id_institute', $institutionId)
                                    ->where('tbl_standard_subject.id_academic_year', $academicId)
                                    ->get(['tbl_institution_subject.id']);
        }        

        public function fetchStandardSubjectsGroupBySubjects($idStandard, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return StandardSubject::join('tbl_institution_subject', 'tbl_institution_subject.id', '=', 'tbl_standard_subject.id_institution_subject')
                                ->where('tbl_standard_subject.id_standard', $idStandard)
                                ->where('tbl_standard_subject.id_institute', $institutionId)
                                ->where('tbl_standard_subject.id_academic_year', $academicId)
                                ->select('tbl_institution_subject.*')
                                ->groupBy('tbl_institution_subject.id_subject')
                                ->get();
        }       

        public function fetchStandardSubjectsGroupBySubjectsWithExamTimetable($idStandard, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return StandardSubject::join('tbl_institution_subject', 'tbl_institution_subject.id', '=', 'tbl_standard_subject.id_institution_subject')
                                ->join('tbl_exam_timetable', 'tbl_exam_timetable.id_institution_subject', '=', 'tbl_institution_subject.id')
                                ->where('tbl_standard_subject.id_standard', $idStandard)
                                ->where('tbl_standard_subject.id_institute', $institutionId)
                                ->where('tbl_standard_subject.id_academic_year', $academicId)
                                ->select('tbl_institution_subject.*')
                                ->groupBy('tbl_institution_subject.id_subject')
                                ->get();
        }
    }
?>
