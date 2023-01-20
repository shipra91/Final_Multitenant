<?php
    namespace App\Repositories;
    use App\Models\ProjectAssignedStudents;
    use App\Interfaces\ProjectAssignedStudentsRepositoryInterface;

    class ProjectAssignedStudentsRepository implements ProjectAssignedStudentsRepositoryInterface{

        public function all(){
            return ProjectAssignedStudents::all();
        }

        public function store($data){
            return $projectAssignedStudents = ProjectAssignedStudents::create($data);
        }

        public function fetch($id){
            return $projectAssignedStudents = ProjectAssignedStudents::where('id_project', $id)->get();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $projectAssignedStudents = ProjectAssignedStudents::where('id_project', $id)->delete();
        }

        public function fetchStudentProject($data){
            
            $idStudent = $data['id_student'];
            $idProject = $data['id_project'];
            return $projectAssignedStudents = ProjectAssignedStudents::where('id_project', $idProject)->where('id_student', $idStudent)->first();
        }
    }