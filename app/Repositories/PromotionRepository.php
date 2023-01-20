<?php 
    namespace App\Repositories;
    use App\Models\Promotion;
    use App\Interfaces\PromotionRepositoryInterface;

    class PromotionRepository implements PromotionRepositoryInterface{

        public function all(){
            return Promotion::all();            
        }

        public function store($data){
            return $promotion = Promotion::create($data);
        }        

        public function fetch($id){
            return $promotion = Promotion::find($id);
        }        

        public function update($data, $id){
            return Promotion::whereId($id)->update($data);
        }        

        public function delete($id){
            return $promotion = Promotion::find($id)->delete();
        }
    }
?>