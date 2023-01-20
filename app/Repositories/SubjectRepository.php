<?php
    namespace App\Repositories;
    use App\Models\Subject;
    use App\Interfaces\SubjectRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;
    use DB;

    class SubjectRepository implements SubjectRepositoryInterface{

        public function all(){
            return Subject::all();
        }

        public function store($data){
            return Subject::create($data);
        }

        public function fetch($id){
            return Subject::find($id);
        }

        public function fetchSubjects($id){
            return Subject::where('id_type', $id)->get();
        }

        // public function update($data, $id){
        //     return Subject::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return Subject::find($id)->delete();
        }

        public function fetchSubjectTypeDetails($idSubject){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
           // DB::enableQueryLog();
            $subjectDetails = Subject::join('tbl_subject_type', 'tbl_subject_type.id', '=', 'tbl_subject.id_type')
                            ->where('tbl_subject.id', $idSubject)
                            ->select('tbl_subject_type.*')
                            ->first();
                            return $subjectDetails;
                       // dd(DB::getQueryLog());

        }

        public function fetchSubjectNameCount($subjectName){
            return Subject::where('name', $subjectName)->get();
        }

        public function getMasterSubjectId($subjectName){
            return Subject::where('name', $subjectName)->first();
        }
    }
?>
