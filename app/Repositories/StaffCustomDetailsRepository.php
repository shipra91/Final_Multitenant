<?php 
    namespace App\Repositories;
    use App\Models\StaffCustomDetails;
    use App\Interfaces\StaffCustomDetailsRepositoryInterface;

    class StaffCustomDetailsRepository implements StaffCustomDetailsRepositoryInterface{

        public function all(){
            return StaffCustomDetails::all();            
        }

        public function store($data){
            return StaffCustomDetails::create($data);
        }        

        public function fetch($id){
            return $staffCustomDetails = StaffCustomDetails::where('id_staff', $id)->get();
        } 

        public function update($data, $id){
            return StaffCustomDetails::whereId($id)->update($data);
        }        

        public function delete($id){
            return $staff = StaffCustomDetails::find($id)->delete();
        }

        public function checkFieldExistence($staffId, $customFieldId){
            return StaffCustomDetails::where('id_staff', $staffId)->where('id_custom_field', $customFieldId)->first();
        }

        // File upload function
        public function upload($file)
        { 
            $path = Storage::disk('s3')->put('egenius_multitenant-s3/staff/test', $file);
            $filePath = Storage::disk('s3')->url($path);
            return $filePath;
        }
    }
?>