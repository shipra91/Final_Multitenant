<?php 
    namespace App\Services;
    use App\Models\Stream;
    use App\Services\StreamService;    
    use App\Repositories\StreamRepository;
    // use App\Interfaces\StreamRepositoryInterface;
    use Carbon\Carbon;
    use Session;

    class StreamService 
    {
        public function getAll()
        {
            $streamRepository = new StreamRepository();
            $stream = $streamRepository->all();
            return $stream;
        }

        public function find($id){
            $streamRepository = new StreamRepository();
            $stream = $streamRepository->fetch($id);
            return $stream;
        }

        public function add($streamData)
        {
            $streamRepository = new StreamRepository();
            $check = Stream::where('name', $streamData->stream)->first();
            if(!$check){
              
                $data = array(
                    'name' => $streamData->stream, 
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );
                $storeData = $streamRepository->store($data); 
                
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

        public function update($streamData, $id){
            $streamRepository = new StreamRepository();
            $check = Stream::where('name', $streamData->stream)->where('id', '!=', $id)->first();
            if(!$check){

                $data = array(
                    'name' => $streamData->stream, 
                    'modified_by' => Session::get('userId'),
                    'updated_at' => Carbon::now()
                );

                $storeData = $streamRepository->update($data, $id); 
              
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
            $streamRepository = new StreamRepository();
            $stream = $streamRepository->delete($id);

            if($stream){
                $signal = 'success';
                $msg = 'Stream deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }

?>