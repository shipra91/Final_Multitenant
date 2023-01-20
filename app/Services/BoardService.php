<?php
    namespace App\Services;
    use App\Models\Board;
    use App\Services\BoardService; 
    use App\Repositories\BoardRepository;
    // use App\Interfaces\BoardRepositoryInterface;
    use App\Interfaces\InstitutionTypeRepositoryInterface;
    use App\Interfaces\InstitutionTypeMappingRepositoryInterface;
    use Carbon\Carbon;
    use Session;

    class BoardService
    {
        public function getAll(){
            $boardRepository = new BoardRepository();
            $board = $boardRepository->all();
            return $board;
        }

        public function find($id){
             $boardRepository = new BoardRepository();
            $board = $boardRepository->fetch($id);
            return $board;
        }

        public function add($boardData)
        {
            $institutionTypeMappingRepository = new InstitutionTypeRepositoryInterface();
            $boardRepository = new BoardRepository();
            $check = Board::where('name', $boardData->board)->first();

            if(!$check){

                $data = array(
                    'name' => $boardData->board,
                    'created_by' => Session::get('userId'),
                    'modified_by' => ''
                );
                $storeData = $boardRepository->store($data);

                if($storeData) {

                    $boardId = $storeData->id;

                    foreach($boardData->institutionType as $institutionType){
                        $typeData = array(
                            "id_board_university" => $boardId,
                            "id_institution_type" => $institutionType,
                            'created_by' => Session::get('userId'),
                            'modified_by' => ''
                        );

                        $storeData = $institutionTypeMappingRepository->store($typeData);
                    }

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

        public function update($boardData, $id){

            $boardRepository = new BoardRepository();
            $check = Board::where('name', $boardData->board)->where('id', '!=', $id)->first();
            if(!$check){

                $data = array(
                    'name' => $boardData->board,
                    'created_by' => 'ADMIN',
                    'modified_by' => 'ADMIN'
                );

                $storeData = $boardRepository->update($data, $id);

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

            $boardRepository = new BoardRepository();
            $board = $boardRepository->delete($id);

            if($board){
                $signal = 'success';
                $msg = 'Board deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
