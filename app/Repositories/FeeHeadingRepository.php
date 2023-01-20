<?php
    namespace App\Repositories;
    use App\Models\FeeHeading;
    use App\Interfaces\FeeHeadingRepositoryInterface;

    class FeeHeadingRepository implements FeeHeadingRepositoryInterface{

        public function all(){
            return FeeHeading::all();
        }

        public function store($data){
            return FeeHeading::create($data);
        }

        public function fetch($id){
            return FeeHeading::find($id);
        }

        public function fetchCategoryWiseHeading($idFeeCategory){
            return FeeHeading::where('id_fee_category', $idFeeCategory)->get();
        }

        // public function update($data, $id){
        //     return FeeHeading::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return FeeHeading::find($id)->delete();
        }
    }
