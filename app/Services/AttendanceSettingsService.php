<?php
    namespace App\Services;
    use App\Models\AttendanceSettings;
    use App\Repositories\AttendanceSettingRepository;
    use App\Services\InstitutionStandardService;
    use Carbon\Carbon;
    use Session;

    class AttendanceSettingsService {

        // Get all attendance settings
        public function getAll($institutionId, $academicYear){

            $attendanceSettingRepository = New AttendanceSettingRepository();
            $institutionStandardService = New InstitutionStandardService();

            $attendanceSettings = $attendanceSettingRepository->all($institutionId, $academicYear);
            $arrayData = array();

            foreach($attendanceSettings as $key => $attendanceSetting){

                $standard = $institutionStandardService->fetchStandardByUsingId($attendanceSetting->id_standard);

                $data = array(
                    'id' => $attendanceSetting->id,
                    'attendance_type' => $attendanceSetting->attendance_type,
                    'id_standard' => $standard,
                    // 'id_template' => $attendanceSetting->id_template,
                    'display_subject' => $attendanceSetting->display_subject,
                    'classtimetable_dependent' => $attendanceSetting->is_subject_classtimetable_dependent,
                    'created_by' => $attendanceSetting->created_by,
                    'modified_by' => $attendanceSetting->modified_by,
                );
                array_push($arrayData, $data);
            }

            return $arrayData;
        }

        // Get particular attendance settings
        public function find($id){

            $attendanceSettingRepository = New AttendanceSettingRepository();
            $institutionStandardService = New InstitutionStandardService();

            $settingsData = array();
            $standard= $template= '';

            $attendanceSetting = $attendanceSettingRepository->fetch($id);
            $standard = $institutionStandardService->fetchStandardByUsingId($attendanceSetting->id_standard);

            if($standard){
                $standards= $standard;
            }

            // if($template){
            //     $template= $gender->name;
            // }

            $settingsData = $attendanceSetting;
            $settingsData['standard'] = $standards;
            //$SettingsData['religion'] = $religion;
            //dd($staffData);
            return $settingsData;
        }

        // Attendance settings data
        public function getAttendanceData($allSessions){

            $attendanceSettingRepository = New AttendanceSettingRepository();
            $institutionStandardService = New InstitutionStandardService();

            $standard = $institutionStandardService->fetchStandard($allSessions);

            $output = array(
                'standard' => $standard,
            );
            return $output;
        }

        // Insert attendance settings
        public function add($settingsData){

            $attendanceSettingRepository = New AttendanceSettingRepository();
            $institutionStandardService = New InstitutionStandardService();

            if($settingsData->standard[0] !=''){

                foreach($settingsData->standard as $key => $standards){

                    $check = AttendanceSettings::where('id_standard', $standards)->withTrashed()->first();

                    if(!$check){

                        $data = array(
                            'attendance_type' => $settingsData->attendanceType,
                            'id_standard' => $standards,
                            // 'id_template' => $settingsData->attendanceTemplate,
                            'display_subject' => $settingsData->displaySubject,
                            'is_subject_classtimetable_dependent' => $settingsData->timetableDependent,
                            'created_by' => Session::get('userId'),
                            'modified_by' => '',
                        );

                        $storeData = $attendanceSettingRepository->store($data);

                        if($storeData){
                            $signal = 'success';
                            $msg = 'Data inserted successfully!';

                        }else{
                            $signal = 'failure';
                            $msg = 'Error inserting data!';
                        }

                    }else{
                        $signal = 'exist';
                        $msg = 'This data already exists!';
                    }
                }
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Update attendance settings
        public function update($settingsData, $id){

            $attendanceSettingRepository = New AttendanceSettingRepository();
            $institutionStandardService = New InstitutionStandardService();

            $check = AttendanceSettings::where('id_standard', $settingsData->standard)
                                        ->where('id', '!=', $id)
                                        ->withTrashed()
                                        ->first();

            if(!$check){

                $data = array(
                    'attendance_type' => $settingsData->attendanceType,
                    'id_standard' => $settingsData->standard,
                    // 'id_template' => $settingsData->attendanceTemplate,
                    'display_subject' => $settingsData->displaySubject,
                    'is_subject_classtimetable_dependent' => $settingsData->timetableDependent,
                    'modified_by' => Session::get('userId'),
                );

                $updateData = $attendanceSettingRepository->update($data, $id);

                if($updateData){
                    $signal = 'success';
                    $msg = 'Data updated successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error updated data!';
                }

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Get all attendance settings
        public function getAttendanceTypeData($attendanceType){

            $attendanceSettingRepository = New AttendanceSettingRepository();
            $institutionStandardService = New InstitutionStandardService();

            $attendanceSettings = $attendanceSettingRepository->allData($attendanceType);
            $arrayData = array();

            foreach($attendanceSettings as $key => $attendanceSetting){

                $standard = $institutionStandardService->fetchStandardByUsingId($attendanceSetting->id_standard);

                $data = array(
                    'id' => $attendanceSetting->id,
                    'attendance_type' => $attendanceSetting->attendance_type,
                    'id_standard' => $attendanceSetting->id_standard,
                    'standard' => $standard,
                    // 'id_template' => $attendanceSetting->id_template,
                    'display_subject' => $attendanceSetting->display_subject,
                    'classtimetable_dependent' => $attendanceSetting->is_subject_classtimetable_dependent,
                    'created_by' => $attendanceSetting->created_by,
                    'modified_by' => $attendanceSetting->modified_by,
                );

                array_push($arrayData, $data);
            }

            return $arrayData;
        }

        // Delete attendance settings
        public function delete($id){

            $attendanceSettingRepository = New AttendanceSettingRepository();

            $attendanceSetting = $attendanceSettingRepository->delete($id);

            if($attendanceSetting){

                $signal = 'success';
                $msg = 'Attendance Setting deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Deleted attendance settings records
        public function getDeletedRecords($allSessions){

            $attendanceSettingRepository = New AttendanceSettingRepository();
            $institutionStandardService = New InstitutionStandardService();

            $attendanceSettings = $attendanceSettingRepository->allDeleted($allSessions);
            $arrayData = array();

            foreach($attendanceSettings as $key => $attendanceSetting){

                $standard = $institutionStandardService->fetchStandardByUsingId($attendanceSetting->id_standard);

                $data = array(
                    'id' => $attendanceSetting->id,
                    'attendance_type' => $attendanceSetting->attendance_type,
                    'id_standard' => $standard,
                    // 'id_template' => $attendanceSetting->id_template,
                    'display_subject' => $attendanceSetting->display_subject,
                    'classtimetable_dependent' => $attendanceSetting->is_subject_classtimetable_dependent,
                    'created_by' => $attendanceSetting->created_by,
                    'modified_by' => $attendanceSetting->modified_by,
                );
                array_push($arrayData, $data);
            }

            return $arrayData;
        }

        // Restore attendance settings records
        public function restore($id){

            $attendanceSettingRepository = New AttendanceSettingRepository();

            $data = $attendanceSettingRepository->restore($id);

            if($data){

                $signal = 'success';
                $msg = 'Data restored successfully!';

            }else{

                $signal = 'failure';
                $msg = 'Data deletion is failed!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>
