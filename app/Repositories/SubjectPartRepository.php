<?php
    namespace App\Repositories;
    use App\Models\SubjectPart;
    use App\Interfaces\SubjectPartRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;
    use DB;

    class SubjectPartRepository implements SubjectPartRepositoryInterface{

        public function all(){

            $allSessions = session()->all();
            $idInstitution = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return SubjectPart::where('id_institute', $idInstitution)
                        ->where('id_academic', $academicYear)
                        ->get();
        }

        public function store($data){
            return SubjectPart::create($data);
        }

        public function fetch($id){
            return SubjectPart::find($id);
        }
        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return SubjectPart::find($id)->delete();
        }
    }
?>
