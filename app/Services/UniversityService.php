<?php 
    namespace App\Services;
    use App\Models\University;
    use App\Repositories\UniversityRepository;

    class UniversityService { 
        // Get All University
        public function getAll(){
            $universityRepository = new UniversityRepository();
            $universities = $universityRepository->all(); 
            return $universities;
        }

        // Get Perticular University
        public function find($id){
            $universityRepository = new UniversityRepository();
            $university = $universityRepository->fetch($id);
            return $university;
        }

        // Add University
        public function add($universityData){
            $universityRepository = new UniversityRepository();

            $check = University::where('name', $universityData->universityName)->first();

            if(!$check){
                        
                $data = array(
                    'name' => $universityData->universityName, 
                    'created_by' =>'Admin',
                    'modified_by' => 'Admin',
                );
                
                $storeData = $universityRepository->store($data); 
        
                if($storeData) {
        
                    $signal = 'success';
                    $msg = 'Data inserted successfully!';
        
                }else{
        
                    $signal = 'failure';
                    $msg = 'Error inserting data!';
                } 
        
            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            } 
        
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
        
            return $output;
        }

        // Update University
        public function update($universityData, $id){
            $universityRepository = new UniversityRepository();

            $check = University::where('name', $universityData->universityName)
                                ->where('id', '!=', $id)->first();
            if(!$check){
                
                $data = array(
                    'name' => $universityData->universityName, 
                    'created_by' =>'Admin',
                    'modified_by' => 'Admin',
                );

                $updateData = $universityRepository->update($data, $id); 
                
                if($updateData) {

                    $signal = 'success';
                    $msg = 'Data updated successfully!';

                }else{

                    $signal = 'failure';
                    $msg = 'Error updated data!';
                } 

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            } 

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Delete University
        public function delete($id){
            $universityRepository = new UniversityRepository();

            $university = $universityRepository->delete($id);

            if($university){
                $signal = 'exist';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>
