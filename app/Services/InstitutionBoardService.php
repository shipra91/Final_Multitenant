<?php 
    namespace App\Services;
    use App\Models\InstitutionBoard;
    use App\Repositories\InstitutionBoardRepository;
    use App\Services\InstitutionCourseMasterService;
    use App\Repositories\BoardRepository;

    class InstitutionBoardService { 

        // Get All Institution Board
        public function getAll($institutionId){
            $institutionBoardRepository = new InstitutionBoardRepository();
            $instituteBoard = $institutionBoardRepository->all($institutionId);
            return $instituteBoard;
        }

        // Get All Institution BoardIds
        public function getAllIds($institutionId){
            
            $institutionBoardRepository = new InstitutionBoardRepository();
            $arrayOutput = array();
            $instituteBoard = $institutionBoardRepository->all($institutionId);
            foreach($instituteBoard as $boardId){
                array_push($arrayOutput, $boardId->id_board);
            }
            return $arrayOutput;
        }

        // Get Perticular Institution Board
        public function find($id){
            $institutionBoardRepository = new InstitutionBoardRepository();
            $instituteBoard = $institutionBoardRepository->fetch($id);
            return $instituteBoard;
        }

        public function getAllInstitutionBoardDetail($institutionId){
            $institutionBoardRepository = new InstitutionBoardRepository();
            $instituteBoard = $institutionBoardRepository->allBoardsDetail($institutionId);
            return $instituteBoard;
        }

        public function getInstitutionBoards($instituteId){
            $boardRepository = new BoardRepository();
            $institutionCourseMasterService = new InstitutionCourseMasterService();
            $courseDetails = $institutionCourseMasterService->getInstitutionCourseDetails($instituteId);
            $board = array();
            
            foreach($courseDetails as $key =>$details)
            {
                $boardData = $boardRepository->fetch($details->board_university);
                $board[$key]['id'] = $details->board_university;
                $board[$key]['name'] = $boardData->name;
            }

            return $board;
        }
    }
?>