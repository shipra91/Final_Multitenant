<?php
    namespace App\Repositories;

    use App\Models\AcademicYearMapping;
    use App\Interfaces\AcademicYearMappingRepositoryInterface;
    use DB;

    class AcademicYearMappingRepository implements AcademicYearMappingRepositoryInterface {

        public function all(){
            return AcademicYearMapping::all();
        }

        public function allExceptSelected($idInstitution, $idAcademicMapping){
            return AcademicYearMapping::where('id_institute', $idInstitution)->where('id', '!=', $idAcademicMapping)->get();
        }

        public function store($data){
            return $academicYearMapping = AcademicYearMapping::create($data);
        }

        public function fetch($id){
            return $academicYearMapping = AcademicYearMapping::join('tbl_academic_years', 'tbl_academic_years.id', '=', 'tbl_academic_year_mappings.id_academic_year')->select('tbl_academic_years.name', 'tbl_academic_years.from_date', 'tbl_academic_years.to_date', 'tbl_academic_year_mappings.*')->where('tbl_academic_year_mappings.id', $id)->first();
        }

        public function getAcademicYearMappingId($academicName, $allSessions){
            $institutionId = $allSessions['institutionId'];

            return AcademicYearMapping::join('tbl_academic_years', 'tbl_academic_years.id', '=', 'tbl_academic_year_mappings.id_academic_year')->select( 'tbl_academic_year_mappings.*')
            ->where('tbl_academic_years.name', $academicName)
            ->where('tbl_academic_year_mappings.id_institute', $institutionId)
            ->first();
        }

        // public function update($data, $id){
        //     return AcademicYearMapping::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $academicYearMapping = AcademicYearMapping::find($id)->delete();
        }

        public function getInstitutionAcademics($idInstitution){
            //\DB::enableQueryLog();
            $academics = AcademicYearMapping::Select('tbl_academic_years.*')
                                ->join('tbl_academic_years', 'tbl_academic_year_mappings.id_academic_year', '=', 'tbl_academic_years.id')
                                ->where('tbl_academic_year_mappings.id_institute', $idInstitution)->get();
                                // dd(\DB::getQueryLog());
            return $academics;
        }

        public function getInstitutionDefaultAcademics($idInstitution){
            //\DB::enableQueryLog();
            $academics = AcademicYearMapping::Select('tbl_academic_years.*', 'tbl_academic_year_mappings.id as idAcademicMapping')
                                ->join('tbl_academic_years', 'tbl_academic_year_mappings.id_academic_year', '=', 'tbl_academic_years.id')
                                ->where('tbl_academic_year_mappings.id_institute', $idInstitution)
                                ->where('tbl_academic_year_mappings.default_year', 'Yes')
                                ->first();
            // dd(\DB::getQueryLog());
            return $academics;
        }

        public function allDeleted(){
            return AcademicYearMapping::onlyTrashed()->get();
        }

        public function restore($id){
            return AcademicYearMapping::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return AcademicYearMapping::onlyTrashed()->restore();
        }
    }
