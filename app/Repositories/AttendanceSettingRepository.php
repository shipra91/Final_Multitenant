<?php
    namespace App\Repositories;
    use App\Models\AttendanceSettings;
    use App\Interfaces\AttendanceSettingRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;
    use Session;

    class AttendanceSettingRepository implements AttendanceSettingRepositoryInterface{

        public function all($institutionId, $academicYear){   
            
            return AttendanceSettings::join('tbl_institution_standard', 'tbl_institution_standard.id', '=', 'tbl_attendance_settings.id_standard')
            ->where('tbl_institution_standard.id_institute', $institutionId)
            ->where('tbl_institution_standard.id_academic_year', $academicYear)
            ->get();
        }

        public function store($data){
            return $attendanceSettings = AttendanceSettings::create($data);
        }

        public function fetch($id){
            return $attendanceSettings = AttendanceSettings::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $attendanceSettings = AttendanceSettings::find($id)->delete();
        }

        // Get all setting data based on attendance type
        public function allData($attendanceType){
            return AttendanceSettings::where('attendance_type', $attendanceType)->get();
        }

        public function allDeleted($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            return AttendanceSettings::join('tbl_institution_standard', 'tbl_institution_standard.id', '=', 'tbl_attendance_settings.id_standard')
                                    ->where('tbl_institution_standard.id_institute', $institutionId)
                                    ->where('tbl_institution_standard.id_academic_year', $academicYear)
                                    ->onlyTrashed()
                                    ->get();
        }

        public function restore($id){
            return AttendanceSettings::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return AttendanceSettings::onlyTrashed()->restore();
        }
    }
?>
