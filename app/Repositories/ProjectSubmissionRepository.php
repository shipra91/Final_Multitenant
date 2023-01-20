<?php
    namespace App\Repositories;
    use App\Models\ProjectSubmission;
    use App\Interfaces\ProjectSubmissionRepositoryInterface;

    class ProjectSubmissionRepository implements ProjectSubmissionRepositoryInterface{

        public function all(){
            return ProjectSubmission::all();
        }

        public function store($data){
            return $projectSubmission = ProjectSubmission::create($data);
        }

        public function fetch($data){
            $idStudent = $data['id_student'];
            $idProject = $data['id_project'];
            return $projectSubmission = ProjectSubmission::where('id_project', $idProject)->where('id_student', $idStudent)->withTrashed()->orderBy('created_at', 'ASC')->get();
        }

        public function fetchData($id){
            return ProjectSubmission::find($id);
        } 

        public function fetchActiveDetails($data){
            $idStudent = $data['id_student'];
            $idProject = $data['id_project'];
            return $projectSubmission = ProjectSubmission::where('id_project', $idProject)->where('id_student', $idStudent)->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($data){
            $idStudent = $data['id_student'];
            $idProject = $data['id_project'];
            
            return ProjectSubmission::where('id_project', $idProject)->where('id_student', $idStudent)->delete();
        }
    }