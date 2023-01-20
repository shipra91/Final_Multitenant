<?php
    namespace App\Repositories;
    use App\Models\ExaminationRoomSettings;
    // use App\Models\RoomMaster;
    use App\Interfaces\ExaminationRoomSettingsRepositoryInterface;

    class ExaminationRoomSettingsRepository implements ExaminationRoomSettingsRepositoryInterface{

        public function all(){
            return ExaminationRoomSettings::all();
        }

        public function store($data){
            return ExaminationRoomSettings::create($data);
        }

        public function fetch($id){
            return ExaminationRoomSettings::find($id);
        }

        // public function update($data, $id){
        //     return ExaminationRoomSettings::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($idExam, $idRoom){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            
            return ExaminationRoomSettings::where('id_exam', $idExam)
                        ->where('id_room', $idRoom)
                        ->where('id_academic_year', $academicYear)
                        ->where('id_institute', $institutionId)
                        ->delete();
        }

        public function getStudentCountForExamRoom($idExam, $idRoom){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return ExaminationRoomSettings::where('id_exam', $idExam)
                        ->where('id_room', $idRoom)
                        ->where('id_academic_year', $academicYear)
                        ->where('id_institute', $institutionId)
                        ->sum('student_count');
        }
    }