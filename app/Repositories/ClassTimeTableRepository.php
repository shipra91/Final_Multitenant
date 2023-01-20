<?php
    namespace App\Repositories;

    use App\Models\ClassTimeTable;
    use App\Interfaces\ClassTimeTableRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class ClassTimeTableRepository implements ClassTimeTableRepositoryInterface {

        public function all(){
            return ClassTimeTable::all();
        }

        public function store($data){
            return $classTimeTable = ClassTimeTable::create($data);
        }

        public function fetch($id){
            return $classTimeTable = ClassTimeTable::find($id);
        }
        public function fetchDetails($periodId){
            return $classTimeTable = ClassTimeTable::where('id_period', $periodId)->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $classTimeTable = ClassTimeTable::find($id)->delete();
        }

        public function fetchTimeTableDetail($idStandard, $day, $idPeriod){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            //DB::enableQueryLog();
            $result = ClassTimeTable::where('id_institute', $institutionId)
                            ->where('id_academic', $academicId)
                            ->where('id_standard', $idStandard)
                            ->where('id_period', $idPeriod)
                            ->where('day', $day)->first();
            //dd(\DB::getQueryLog());
            // dd($result);
            return $result;
        }

        // Fetch staff class time table
        public function fetchClassTimeTableData($staffId, $day, $period){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
           

            DB::enableQueryLog();
            $students = ClassTimeTable::Select('tbl_class_time_table.id_standard', 'tbl_class_time_table.id_period', 'tbl_class_time_table_detail.id_subject', 'tbl_class_time_table_detail.id_room','tbl_class_time_table_setting.start_time', 'tbl_class_time_table_setting.end_time')
                        ->join('tbl_class_time_table_detail', 'tbl_class_time_table_detail.id_class_time_table', '=', 'tbl_class_time_table.id')
                        ->join('tbl_period_setting', 'tbl_period_setting.id_standard', '=', 'tbl_class_time_table.id_standard')
                        ->join('tbl_class_time_table_setting', 'tbl_class_time_table_setting.id_period_setting', '=', 'tbl_period_setting.id')
                        // ->join('tbl_class_time_table_setting', 'tbl_class_time_table_setting.id_period', '=', 'tbl_class_time_table.id_period')
                        ->where('tbl_class_time_table.id_institute', $institutionId)
                        ->where('tbl_class_time_table.id_academic', $academicYear)
                        ->whereRaw('FIND_IN_SET(?, tbl_class_time_table_detail.id_staffs)',[$staffId])
                        ->where('tbl_class_time_table.day', $day)
                        ->where('tbl_class_time_table.id_period', $period)
                        ->where('tbl_class_time_table_setting.id_period', $period)
                        ->whereNull('tbl_class_time_table_detail.deleted_at')
                        ->whereNull('tbl_class_time_table_setting.deleted_at')
                        ->first();
            // dd(\DB::getQueryLog());
            return $students;
        }

         // Fetch staff class time table
         public function fetchStandardClassTimeTableData($studentSubjects, $idStandard, $day, $period, $institutionId , $academicYear ){

            DB::enableQueryLog();
            $students = ClassTimeTable::Select('tbl_class_time_table.id_standard', 'tbl_class_time_table.id_period', 'tbl_class_time_table_detail.id_subject', 'tbl_class_time_table_detail.id_room','tbl_class_time_table_setting.start_time', 'tbl_class_time_table_setting.end_time' , 'tbl_class_time_table_detail.id_staffs')
                        ->join('tbl_class_time_table_detail', 'tbl_class_time_table_detail.id_class_time_table', '=', 'tbl_class_time_table.id')
                        ->join('tbl_period_setting', 'tbl_period_setting.id_standard', '=', 'tbl_class_time_table.id_standard')
                        ->join('tbl_class_time_table_setting', 'tbl_class_time_table_setting.id_period_setting', '=', 'tbl_period_setting.id')
                        ->where('tbl_class_time_table.id_institute', $institutionId)
                        ->where('tbl_class_time_table.id_academic', $academicYear)
                        ->where('tbl_class_time_table.day', $day)
                        ->where('tbl_class_time_table.id_period', $period)
                        ->where('tbl_class_time_table.id_standard', $idStandard)  ->whereIn('tbl_class_time_table_detail.id_subject', $studentSubjects)
                        ->whereNull('tbl_class_time_table_detail.deleted_at')
                        ->whereNull('tbl_class_time_table_setting.deleted_at')
                        ->first();
            // dd(\DB::getQueryLog());
            return $students;
        }

        public function fetchStandardPeriodData($idStandard, $day, $period, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            DB::enableQueryLog();
            $classTimeTableData = ClassTimeTable::join('tbl_class_time_table_detail', 'tbl_class_time_table_detail.id_class_time_table', '=', 'tbl_class_time_table.id')
                        ->where('tbl_class_time_table.id_institute', $institutionId)
                        ->where('tbl_class_time_table.id_academic', $academicYear)
                        ->where('tbl_class_time_table.day', $day)
                        ->where('tbl_class_time_table.id_period', $period)
                        ->where('tbl_class_time_table.id_standard', $idStandard)  
                        ->whereNull('tbl_class_time_table_detail.deleted_at')
                        ->get();
            // dd(\DB::getQueryLog());
            return $classTimeTableData;
        }

        
    }
