<?php
    namespace App\Repositories;
    use App\Models\InstitutionStandard;
    use App\Models\InstitutionStandardType;
    use App\Interfaces\InstitutionStandardRepositoryInterface;
    use Session;
    use DB;

    class InstitutionStandardRepository implements InstitutionStandardRepositoryInterface{

        public function all($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return InstitutionStandard::where('id_institute', $institutionId)
                                        // ->where('id_academic_year', $academicId)
                                        ->get();
        }

        public function store($data){
            return  InstitutionStandard::create($data);
        }

        public function fetch($id){
            return InstitutionStandard::find($id);
        }

        public function fetchStandard($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return InstitutionStandard::join('tbl_standard', 'tbl_standard.id', '=', 'tbl_institution_standard.id_standard')
                                        ->where('tbl_institution_standard.id_institute', $institutionId)
                                        // ->where('tbl_institution_standard.id_academic_year', $academicId)
                                        ->groupBy('tbl_institution_standard.id_standard')
                                        ->get(['tbl_institution_standard.*']);
        }

        public function fetchStreams($idStandard){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return InstitutionStandard::join('tbl_standard', 'tbl_standard.id', '=', 'tbl_institution_standard.id_standard')
                                        ->where('tbl_institution_standard.id_institute', $institutionId)
                                        // ->where('tbl_institution_standard.id_academic_year', $academicId)
                                        ->where('tbl_institution_standard.id_standard', $idStandard)
                                        ->groupBy('tbl_institution_standard.id_stream')
                                        ->get(['tbl_institution_standard.*']);
        }

        public function update($data, $id){
            return InstitutionStandard::whereId($id)->update($data);
        }

        public function delete($id){
            return InstitutionStandard::find($id)->delete();
        }

        public function getInstitutionStandardType(){
            return  InstitutionStandardType::all();
        }

        public function fetchStandardDetails($request, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $standardStream = explode('/', $request);
            $standardId = $standardStream[0];
            $streamId = $standardStream[1];

            return InstitutionStandard::where('id_institute', $institutionId)
                                        // ->where('id_academic_year', $academicId)
                                        ->where('id_standard', $standardId)
                                        ->where('id_stream', $streamId)
                                        ->get();
        }

        public function fetchStandardGroupByCombination($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            //DB::enableQueryLog();
            $data = InstitutionStandard::join('tbl_standard', 'tbl_standard.id', '=', 'tbl_institution_standard.id_standard')
                                        ->where('tbl_institution_standard.id_institute', $institutionId)
                                        // ->where('tbl_institution_standard.id_academic_year', $academicId)
                                        ->groupBy('tbl_institution_standard.id_combination')
                                        ->get(['tbl_institution_standard.*']);
            //dd(\DB::getQueryLog());
            return $data;
        }

        public function getDivisions($idStandard, $idYear, $idSem, $idStream, $idCombination){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            //DB::enableQueryLog();
            $data = InstitutionStandard::select('tbl_institution_standard.*', 'tbl_division.name')
                                        ->join('tbl_standard', 'tbl_standard.id', '=', 'tbl_institution_standard.id_standard')
                                        ->join('tbl_division', 'tbl_division.id', '=', 'tbl_institution_standard.id_division')
                                        ->join('tbl_stream', 'tbl_stream.id', '=', 'tbl_institution_standard.id_stream')
                                        ->join('tbl_combination', 'tbl_combination.id', '=', 'tbl_institution_standard.id_combination')
                                        ->leftJoin('tbl_standard_year', 'tbl_standard_year.id', '=', 'tbl_institution_standard.id_year')
                                        ->leftJoin('tbl_year_sem_mapping', 'tbl_year_sem_mapping.id', '=', 'tbl_institution_standard.id_sem')
                                        ->where('tbl_institution_standard.id_institute', $institutionId)
                                        // ->where('tbl_institution_standard.id_academic_year', $academicId)
                                        ->where('tbl_institution_standard.id_standard', $idStandard)
                                        ->where('tbl_institution_standard.id_year', $idYear)
                                        ->where('tbl_institution_standard.id_sem', $idSem)
                                        ->where('tbl_institution_standard.id_stream', $idStream)
                                        ->where('tbl_institution_standard.id_combination', $idCombination)
                                        ->groupBy('tbl_institution_standard.id_division')
                                        ->get();
            //dd(\DB::getQueryLog());
            return $data;
        }

        public function getInstitutionStandardId($details, $allSessions){
            $institutionId = $allSessions['institutionId'];
            return InstitutionStandard::where('id_institute', $institutionId)
                                        ->where('id_standard', $details['standardId'])
                                        ->where('id_division', $details['divisionId'])
                                        ->where('id_year', $details['yearId'])
                                        ->where('id_sem', $details['semId'])
                                        ->where('id_stream', $details['streamId'])
                                        ->where('id_combination', $details['combinationId'])
                                        ->where('id_board', $details['boardId'])
                                        ->where('id_course', $details['courseId'])
                                        ->first();
        }
    }
?>
