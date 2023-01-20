<?php
    namespace App\Repositories;
    use App\Models\CurrencyDenomination;
    use App\Interfaces\CurrencyDenominationRepositoryInterface;
    use DB;

    class CurrencyDenominationRepository implements CurrencyDenominationRepositoryInterface{

        public function all(){
            return CurrencyDenomination::all();
        }

        public function store($data){
            return $currencyDenomination = CurrencyDenomination::create($data);
        }

        public function fetch($id){            
            $currencyDenomination = CurrencyDenomination::find($id);
            return $currencyDenomination;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $currencyDenomination = CurrencyDenomination::find($id)->delete();
        }
    }
