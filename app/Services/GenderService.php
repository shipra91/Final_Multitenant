<?php 
    namespace App\Services;
    use App\Models\Gender;
    use App\Services\GenderService;
    use App\Repositories\GenderRepository;
    use Carbon\Carbon;

    class GenderService 
    {
        
        public function getAll(){
            $genderRepository = new GenderRepository();
            $gender = $genderRepository->all();
            return $gender;
        }

        public function find($id){
            $genderRepository = new GenderRepository();
            $gender = $genderRepository->fetch($id);
            return $gender;
        }

        public function add($genderData)
        {
            $genderRepository = new GenderRepository();
            $check = Gender::where('name', $genderData->gender)->first();
            if(!$check){
              
                $data = array(
                    'name' => $genderData->gender, 
                    'created_by' => 'ADMIN',
                    'modified_by' => 'ADMIN'
                );
                $storeData = $genderRepository->store($data); 
                
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

        public function update($genderData, $id){
            $genderRepository = new GenderRepository();
            
            $check = Gender::where('name', $genderData->gender)->where('id', '!=', $id)->first();
            if(!$check){

                $data = array(
                    'name' => $genderData->gender, 
                    'created_by' => 'ADMIN',
                    'modified_by' => 'ADMIN'
                );

                $storeData = $genderRepository->update($data, $id); 
              
                if($storeData) {

                    $signal = 'success';
                    $msg = 'Data updated successfully!';

                }else{

                    $signal = 'failure';
                    $msg = 'Error updating data!';

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

         public function delete($id){
            $genderRepository = new GenderRepository();
            
            $gender = $genderRepository->delete($id);

            if($gender){
                $signal = 'success';
                $msg = 'Gender deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
