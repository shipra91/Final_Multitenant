<?php
    namespace App\Repositories;

    use App\Models\Period;
    use App\Interfaces\PeriodRepositoryInterface;

    class PeriodRepository implements PeriodRepositoryInterface{

        public function all(){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return Period::where('tbl_periods.id_institute', $institutionId)
                        ->where('tbl_periods.id_academic_year', $academicYear)
                        ->get();
        }

        public function store($data){
            return $data = Period::create($data);
        }

        public function fetch($id){
            return $data = Period::find($id);
        }

        public function update($data, $id){
            return Period::whereId($id)->update($data);
        }

        public function delete($id){
            return $data = Period::find($id)->delete();
        }

        public function periodCount($type){
            return $data = Period::where('type', $type)->count();
        }

        public function getPeriodTypeWise(){
            return $data = Period::where('type', 'teaching')->orderBy('priority')->get();
        }

        public function allDeleted(){
            return Period::onlyTrashed()->get();
        }

        public function restore($id){
            return Period::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return Period::onlyTrashed()->restore();
        }
    }
?>
