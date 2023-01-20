<?php
    namespace App\Repositories;
    use App\Models\ProjectSubmissionPermission;
    use App\Interfaces\ProjectSubmissionPermissionRepositoryInterface;

    class ProjectSubmissionPermissionRepository implements ProjectSubmissionPermissionRepositoryInterface{

        public function all(){
            return ProjectSubmissionPermission::all();
        }

        public function store($data){
            return $projectSubmissionPermission = ProjectSubmissionPermission::create($data);
        }

        public function fetch($data){
            $idStudent = $data['id_student'];
            $idProject = $data['id_project'];
            return $projectSubmissionPermission = ProjectSubmissionPermission::where('id_project', $idProject)->where('id_student', $idStudent)->withTrashed()->orderBy('created_at', 'ASC')->get();
        }

        public function fetchData($id){
            return ProjectSubmissionPermission::find($id);
        } 

        public function fetchActiveDetails($data){
            $idStudent = $data['id_student'];
            $idProject = $data['id_project'];
            return $projectSubmissionPermission = ProjectSubmissionPermission::where('id_project', $idProject)->where('id_student', $idStudent)->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return ProjectSubmissionPermission::find($id)->delete();
        }
    }