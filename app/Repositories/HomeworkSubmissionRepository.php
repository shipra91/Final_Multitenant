<?php
    namespace App\Repositories;
    use App\Models\HomeworkSubmission;
    use App\Interfaces\HomeworkSubmissionRepositoryInterface;

    class HomeworkSubmissionRepository implements HomeworkSubmissionRepositoryInterface{

        public function all(){
            return HomeworkSubmission::all();
        }

        public function store($data){
            return $homeworkSubmission = HomeworkSubmission::create($data);
        }

        public function fetch($data){
            $idStudent = $data['id_student'];
            $idHomework = $data['id_homework'];
            return $homeworkSubmission = HomeworkSubmission::where('id_homework', $idHomework)->where('id_student', $idStudent)->withTrashed()->orderBy('created_at', 'ASC')->get();
        }

        public function fetchData($id){
            return HomeworkSubmission::find($id);
        } 

        public function fetchActiveDetails($data){
            $idStudent = $data['id_student'];
            $idHomework = $data['id_homework'];
            return $homeworkSubmission = HomeworkSubmission::where('id_homework', $idHomework)->where('id_student', $idStudent)->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($data){
            $idStudent = $data['id_student'];
            $idHomework = $data['id_homework'];
            
            return HomeworkSubmission::where('id_homework', $idHomework)->where('id_student', $idStudent)->delete();
        }
    }