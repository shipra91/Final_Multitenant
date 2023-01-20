<?php
    namespace App\Services;
    use App\Models\StaffBoardSelection;
    use App\Repositories\StaffBoardRepository;
    use App\Repositories\BoardRepository;

    class StaffBoardService {
        // Get All Staff BoardIds
        public function getAllIds($staffId){
            $staffBoardRepository = new StaffBoardRepository();
            $allBoards = array();

            $boardDetails = $staffBoardRepository->all($staffId);

            foreach($boardDetails as $boardDetail){
                $allBoards = explode(",", $boardDetail->board);
                $allBoards['id'] = $boardDetail->id;
            }
            return $allBoards;
        }
    }
