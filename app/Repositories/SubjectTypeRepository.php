<?php 
    namespace App\Repositories;
    use App\Models\SubjectType;
    use App\Interfaces\SubjectTypeRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;

    class SubjectTypeRepository implements SubjectTypeRepositoryInterface{

        public function all(){
            return SubjectType::all();            
        }

        public function fetchSubjectDetails($id)
        {
            return SubjectType::join('tbl_subject', 'tbl_subject.id_type', '=', 'tbl_subject_type.id')
            ->where('tbl_subject.id', $id)
            ->select('tbl_subject_type.label')
            ->first();
        }  

        public function fetch($id){
            return SubjectType::find($id);
        }    
    }
?>