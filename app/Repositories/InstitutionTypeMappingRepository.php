<?php
    namespace App\Repositories;
    use App\Models\InstitutionTypeMapping;
    use App\Interfaces\InstitutionTypeMappingRepositoryInterface;

    class InstitutionTypeMappingRepository implements InstitutionTypeMappingRepositoryInterface{

        public function all(){
            return InstitutionTypeMapping::all();
        }

        // public function all($boardId){
        //     return InstitutionTypeMapping::where('id_board_university', $boardId)->get();
        // }

        public function store($data){
            return $institutionType = InstitutionTypeMapping::create($data);
        }

        public function fetch($id){
            return $institutionType = InstitutionTypeMapping::find($id);
        }

        public function update($data, $id){
            return InstitutionTypeMapping::whereId($id)->update($data);
        }

        public function delete($id){
            return $institutionType = InstitutionTypeMapping::find($id)->delete();
        }
    }
?>
