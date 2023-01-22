<?php
    namespace App\Services;
    use App\Models\ExaminationRoomSettings;
    use App\Repositories\ExamRoomStudentMappingRepository;
    use App\Repositories\ExaminationRoomSettingsRepository;
    use App\Repositories\RoomMasterRepository;
    use App\Repositories\ExamMasterRepository;
    use Session;
    use Carbon\Carbon;

    class ExaminationRoomSettingsService{

        // Get All Room
<<<<<<< HEAD
        public function getAll()
=======
        public function getAll($allSessions)
>>>>>>> main
        {
            $examinationRoomSettingsRepository =  new ExaminationRoomSettingsRepository();
            $roomMasterRepository = new RoomMasterRepository();
            $examMasterRepository = new ExamMasterRepository();
            $allExamRoomDetails = array();
            
<<<<<<< HEAD
            $allExamRoomData = $examinationRoomSettingsRepository->all();
=======
            $allExamRoomData = $examinationRoomSettingsRepository->all($allSessions);
>>>>>>> main
            foreach($allExamRoomData as $index => $details){

                $buildingName = $blockName = $floorNumber = $display_name = "";
                
                $allExamRoomDetails[$index] = $details;
                $roomData = $roomMasterRepository->fetch($details['id_room']);
                $examData = $examMasterRepository->fetch($details['id_exam']);
<<<<<<< HEAD
                $countStudent = $examinationRoomSettingsRepository->getStudentCountForExamRoom($details['id_exam'], $details['id_room']);
=======
                $countStudent = $examinationRoomSettingsRepository->getStudentCountForExamRoom($details['id_exam'], $details['id_room'], $allSessions);
>>>>>>> main
                
                $allExamRoomDetails[$index]['room_no'] = $roomData->display_name;
                $allExamRoomDetails[$index]['count'] = $countStudent;
                $allExamRoomDetails[$index]['exam_name'] = $examData->name;
            }
            return $allExamRoomDetails;
        }
       
        public function add($examRoomData)
        {
            //dd($examRoomData);
<<<<<<< HEAD
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
=======
            $institutionId = $examRoomData->id_institute;
            $academicYear = $examRoomData->id_academic;

>>>>>>> main
            $examinationRoomSettingsRepository =  new ExaminationRoomSettingsRepository();
            $examRoomStudentMappingRepository =  new ExamRoomStudentMappingRepository();
            if($examRoomData->exam[0] != '')
            {
                foreach($examRoomData->exam as $key => $idExam) 
                { 
                    $idStandard = $examRoomData->standard[$key];
                    $idSubject = $examRoomData->subject[$key];
                    $idRoom = $examRoomData->roomNo[$key];
                    $rollNo = $examRoomData->roll_no[$key+1];
                  
                    $internalInvigilator = $examRoomData->internalInvigilator[$key];
                    $externalInvigilator = $examRoomData->externalInvigilator[$key];
                    $count = $examRoomData->count[$key];

                    $check = ExaminationRoomSettings::where('id_exam', $idExam)->where('id_standard', $idStandard)->where('id_room', $idRoom)->where('id_subject', $idSubject)->first();
                    
                    if(!$check)
                    {
                        $data = array(
                            'id_academic_year' => $academicYear,
                            'id_institute' => $institutionId,
                            'id_exam' => $idExam,
                            'id_standard' => $idStandard,
                            'id_room' => $idRoom,
                            'id_subject' => $idSubject,
                            'student_count' => $count,
                            'internal_invigilator' => $internalInvigilator,
                            'external_invigilator' => $externalInvigilator,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );

                        $examinationRoomSetting = $examinationRoomSettingsRepository->store($data);
                        $examinationRoomSettingId = $examinationRoomSetting->id;
                    }
                    else
                    {
                        $examinationRoomSettingId = $check->id;
                        $examRoomStudentMappingRepository->delete($examinationRoomSettingId);
                        
                    }

                    if($examinationRoomSettingId)
                    {
                        foreach($rollNo as $data)
                        {
                            $data = array(
                            'id_academic_year' => $academicYear,
                            'id_institute' => $institutionId,
                            'id_examination_room_setting' => $examinationRoomSettingId,
                            'id_student' => $data,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                            );

                             $examRoomStudentData = $examRoomStudentMappingRepository->store($data);
                        }
                    }
                }
            }

            $signal = 'success';
            $msg = 'Data inserted successfully!';

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;
        }

        // Delete event
<<<<<<< HEAD
        public function delete($idExam, $idRoom){
=======
        public function delete($idExam, $idRoom, $allSessions){
>>>>>>> main

            $examinationRoomSettingsRepository =  new ExaminationRoomSettingsRepository();
            $roomSetting = $examinationRoomSettingsRepository->delete($idExam, $idRoom);

            if($roomSetting){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }