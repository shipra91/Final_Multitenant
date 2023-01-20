<?php 
    namespace App\Repositories;
    use App\Models\InstitutionBoard;
    use App\Interfaces\InstitutionBoardRepositoryInterface;
    use DB;

    class InstitutionBoardRepository implements InstitutionBoardRepositoryInterface{

        public function all($institutionId){
            return InstitutionBoard::where('id_institution', $institutionId)->get();                
        }

        public function allBoardsDetail($institutionId){
            return InstitutionBoard::join('tbl_board', 'tbl_board.id', '=', 'tbl_institution_boards.id_board')
            ->select('tbl_board.name', 'tbl_board.id')
            ->where('tbl_institution_boards.id_institution', $institutionId)
            ->get();                
        }


        public function store($data){
            return $Institutionboard = InstitutionBoard::create($data);
        }        

        public function fetch($id){
            return $Institutionboard = InstitutionBoard::find($id);
        }        

        public function update($data, $id){
            return InstitutionBoard::whereId($id)->update($data);
        }        

        public function delete($id){
            return $Institutionboard = InstitutionBoard::find($id)->delete();
        }        

        public function getBoardId($institutionId, $boardId){
            // \DB::enableQueryLog();
            return $InstitutionModule = InstitutionBoard::where('id_institution', $institutionId)->where('id_board', $boardId)->first();
            // dd(\DB::getQueryLog());
        }

        public function restore($id){
            return InstitutionBoard::withTrashed()->find($id)->restore();
        }
    }
?>