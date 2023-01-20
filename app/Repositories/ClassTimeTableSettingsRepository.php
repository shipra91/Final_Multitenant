<?php
    namespace App\Repositories;
    use App\Models\ClassTimeTableSettings;
    use App\Interfaces\ClassTimeTableSettingsRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class ClassTimeTableSettingsRepository implements ClassTimeTableSettingsRepositoryInterface{

        public function all(){
            return ClassTimeTableSettings::all();
        }

        public function store($data){
            return $classTimeTableSettings = ClassTimeTableSettings::create($data);
        }

        public function fetch($id){
            return $classTimeTableSettings = ClassTimeTableSettings::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $classTimeTableSettings = ClassTimeTableSettings::find($id)->delete();
        }

        public function getAllTimetableSettings($periodSettingsId){
            $data = classTimeTableSettings::where('id_period_setting', $periodSettingsId)->get();
            return $data;
        }

        public function getClassTimetableSettings($periodSettingsId){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $data = classTimeTableSettings::join('tbl_periods', 'tbl_periods.id', '=', 'tbl_class_time_table_setting.id_period')->where('id_period_setting', $periodSettingsId)->where('tbl_periods.type', 'teaching')->select('tbl_class_time_table_setting.*', 'tbl_periods.name as period')
            ->orderBy('tbl_class_time_table_setting.created_at')
            ->get();
            return $data;
        }

        // Fetch data
        public function fetchTimeTableTime($idPeriod, $idStandard){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $data = classTimeTableSettings::join('tbl_period_setting', 'tbl_period_setting.id', '=', 'tbl_class_time_table_setting.id_period_setting')
            ->where('tbl_class_time_table_setting.id_period', $idPeriod)
            ->where('tbl_period_setting.id_standard', $idStandard)
            ->first();
            return $data;
        }

    }
