<?php 
    namespace App\Repositories;
    use App\Models\Certificate;
    use App\Interfaces\CertificateRepositoryInterface;

    class CertificateRepository implements CertificateRepositoryInterface{

        public function all(){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return Certificate::where('id_institute', $institutionId)->where('id_academic', $academicYear)->get();            
        }

        public function store($data){
            return Certificate::create($data);
        }        

        public function fetch($id){
            return Certificate::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id){
            return Certificate::find($id)->delete();
        }       

        public function certificateCount($idTemplate){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return Certificate::where('id_institute', $institutionId)->where('id_academic', $academicYear)->where('id_template', $idTemplate)->count();
        }   
    }
?>