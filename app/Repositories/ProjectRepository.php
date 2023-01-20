<?php
    namespace App\Repositories;
    use App\Models\Project;
    use App\Interfaces\ProjectRepositoryInterface;
    use DB;

    class ProjectRepository implements ProjectRepositoryInterface{

        public function all($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            
            return Project::where('id_institute', $institutionId)->where('id_academic', $academicYear)->get();
        }

        public function store($data){
            return $project = Project::create($data);
        }

        public function fetch($id){
            return $project = Project::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $project = Project::find($id)->delete();
        }

        public function fetchProjectByStudent($idStudent, $allSessions){
            // DB::enableQueryLog();
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return $assignment = Project::join('tbl_project_assigned_students','tbl_project_assigned_students.id_project', '=', 'tbl_project.id')
                                            ->where('tbl_project.id_institute', $institutionId)
                                            ->where('tbl_project.id_academic', $academicId)
                                            ->where('tbl_project_assigned_students.id_student', $idStudent)
                                            ->select('tbl_project.*')
                                            ->groupBy('tbl_project_assigned_students.id_project')->get();
            // dd(DB::getQueryLog());
        }

        public function fetchProjectUsingStaff($idStaff, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return $assignment = Project::where('id_institute', $institutionId)
                                            ->where('id_academic', $academicId)
                                            ->where('id_staff', $idStaff)
                                            ->get();

        }

        public function allDeleted($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return Project::where('id_institute', $institutionId)
                            ->where('id_academic', $academicId)
                            ->onlyTrashed()
                            ->get();
        }        

        public function restore($id){
            return Project::withTrashed()->find($id)->restore();
        }

        public function restoreAll($allSessions){
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return Project::where('id_institute', $institutionId)
                            ->where('id_academic', $academicId)
                            ->onlyTrashed()
                            ->restore();
        }
       
    }
