<?php
    namespace App\Repositories;
    use App\Models\FineOptions;
    use App\Interfaces\FineOptionsRepositoryInterface;
    use DB;

    class FineOptionsRepository implements FineOptionsRepositoryInterface{

        public function all(){
            return FineOptions::all();
        }

        public function store($data){
            return $fineOptions = FineOptions::create($data);
        }

        public function fetch($label){            
            $fineOptions = FineOptions::where('label', $label)->first();
            return $fineOptions;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $fineOptions = FineOptions::find($id)->delete();
        }
    }
