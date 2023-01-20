<?php
    namespace App\Repositories;
    use App\Models\Preadmission;
    use App\Interfaces\PreadmissionRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;

    class PreadmissionRepository implements PreadmissionRepositoryInterface {

        public function all($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return Preadmission::where('id_institute', $institutionId)->where('id_academic_year', $academicYear)->get();
        }

        public function store($data){
            return Preadmission::create($data);
        }

        public function fetch($id){
            return Preadmission::find($id);
        }

        public function getMaxPreadmissionId(){
            return Preadmission::max('application_number');
        }

        // public function update($data, $id){
        //     return Preadmission::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return Preadmission::find($id)->delete();
        }

        // File upload function
        public function upload($file){

            $path = Storage::disk('s3')->put('egenius_multitenant-s3/preadmission/test', $file);
            $filePath = Storage::disk('s3')->url($path);

            return $filePath;
        }

        // fetch student based on standard
        public function findStudent($standardId){

            // DB::enableQueryLog();
            return Preadmission::where('id_standard', $standardId)
                                ->where('admitted', 'NO')
                                ->get();
            // dd(DB::getQueryLog());
        }
    }
?>
