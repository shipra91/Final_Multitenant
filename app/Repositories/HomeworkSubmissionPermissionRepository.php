<?php
    namespace App\Repositories;
    use App\Models\HomeworkSubmissionPermission;
    use App\Interfaces\HomeworkSubmissionPermissionRepositoryInterface;

    class HomeworkSubmissionPermissionRepository implements HomeworkSubmissionPermissionRepositoryInterface{

        public function all(){
            return HomeworkSubmissionPermission::all();
        }

        public function store($data){
            return $homeworkSubmissionPermission = HomeworkSubmissionPermission::create($data);
        }

        public function fetch($data){
            $idStudent = $data['id_student'];
            $idHomework = $data['id_homework'];
            return $homeworkSubmissionPermission = HomeworkSubmissionPermission::where('id_homework', $idHomework)->where('id_student', $idStudent)->withTrashed()->orderBy('created_at', 'ASC')->get();
        }

        public function fetchData($id){
            return HomeworkSubmissionPermission::find($id);
        } 

        public function fetchActiveDetails($data){
            $idStudent = $data['id_student'];
            $idHomework = $data['id_homework'];
            return $homeworkSubmissionPermission = HomeworkSubmissionPermission::where('id_homework', $idHomework)->where('id_student', $idStudent)->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return HomeworkSubmissionPermission::find($id)->delete();
        }
    }