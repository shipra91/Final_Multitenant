<?php 
    namespace App\Services;
    use App\Models\RoomMaster;
    use App\Repositories\RoomMasterRepository;
    use Session;
    use Carbon\Carbon;

    class RoomMasterService 
    {
        public function all()
        {
            $institutionStandardService = new InstitutionStandardService();
            $roomMasterRepository = new RoomMasterRepository();
            return $roomMasterRepository->all();
        }

        public function find($id)
        {
            $roomMasterRepository = new RoomMasterRepository();
            return $roomMasterRepository->fetch($id);
        }
    
        public function add($roomMasterData)
        {
            $roomMasterRepository = new RoomMasterRepository();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            if($roomMasterData->building_name[0] !='')
            {
                foreach($roomMasterData->building_name as $key => $buildingName) 
                {
                    $blockName = $roomMasterData->block_name[$key];
                    $floorNumber = $roomMasterData->floor_number[$key];
                    $roomNumber = $roomMasterData->room_number[$key];
                    $displayName = $roomMasterData->display_name[$key];
                    $regularCapacity = $roomMasterData->regular_capacity[$key];
                    $examCapacity = $roomMasterData->exam_capacity[$key];

                    $check = RoomMaster::where('id_academic_year', $academicYear)
                            ->where('id_institute', $institutionId)->where('building_name', $buildingName)->where('block_name', $blockName)->where('floor_number', $floorNumber)->where('room_number', $roomNumber)->where('display_name', $displayName)->first();
                    if(!$check)
                    {
                        $data = array( 
                        'id_academic_year' => $academicYear,
                        'id_institute' => $institutionId,
                        'building_name' => $buildingName,
                        'block_name' => $blockName,
                        'floor_number' => $floorNumber,
                        'room_number' => $roomNumber,
                        'display_name' => $displayName,
                        'regular_capacity' => $regularCapacity,
                        'exam_capacity' => $examCapacity,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                        );

                        $store = $roomMasterRepository->store($data);
                    }
                }
            }


            $signal = 'success';
            $msg = 'Data inserted successfully!';
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;
        }

        public function update($roomMasterData, $id){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $roomMasterRepository = new RoomMasterRepository();
            $roomDetails = $roomMasterRepository->fetch($id);
            $buildingName = $roomMasterData->building_name;
            $blockName = $roomMasterData->block_name;
            $floorNumber = $roomMasterData->floor_number;
            $roomNumber = $roomMasterData->room_number;
            $displayName = $roomMasterData->display_name;
            $regularCapacity = $roomMasterData->regular_capacity;
            $examCapacity = $roomMasterData->exam_capacity;

            $check = RoomMaster::where('id_academic_year', $academicYear)
                                ->where('id_institute', $institutionId)->where('building_name', $buildingName)->where('block_name', $blockName)->where('floor_number', $floorNumber)->where('room_number', $roomNumber)->where('display_name', $displayName)->where('id', '!=', $id)->first();
            if(!$check){

                $roomDetails->building_name = $buildingName;
                $roomDetails->block_name = $blockName;
                $roomDetails->floor_number = $floorNumber;
                $roomDetails->room_number = $roomNumber;
                $roomDetails->display_name = $displayName;
                $roomDetails->regular_capacity = $regularCapacity;
                $roomDetails->exam_capacity = $examCapacity;

                $updateData = $roomMasterRepository->update($roomDetails); 
              
                if($updateData) {

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
     
    }
?>