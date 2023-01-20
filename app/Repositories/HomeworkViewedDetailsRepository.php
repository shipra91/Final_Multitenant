<?php
    namespace App\Repositories;
    use App\Models\HomeworkViewedDetails;
    use App\Interfaces\HomeworkViewedDetailsRepositoryInterface;

    class HomeworkViewedDetailsRepository implements HomeworkViewedDetailsRepositoryInterface{

        public function all(){
            return HomeworkViewedDetails::all();
        }

        public function store($data){
            return $homeworkViewedDetails = HomeworkViewedDetails::create($data);
        }

        public function fetch($data){
            $idStudent = $data['id_student'];
            $idHomework = $data['id_homework'];
            return $homeworkViewedDetails = HomeworkViewedDetails::where('id_homework', $idHomework)->where('id_student', $idStudent)->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($data){
            $idStudent = $data['id_student'];
            $idHomework = $data['id_homework'];
            
            return HomeworkViewedDetails::where('id_homework', $idHomework)->where('id_student', $idStudent)->delete();
        }
    }