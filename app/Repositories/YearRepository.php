<?php 
    namespace App\Repositories;
    use App\Models\Year;
    use App\Interfaces\YearRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;

    class YearRepository implements YearRepositoryInterface{

        public function all(){
            //return Year::all();    
            return Year::orderBy('created_at', 'ASC')->get();           
        }

        public function getAll(){
            return Year::all();            
        }

        public function store($data){
            return Year::create($data);
        }        

        public function fetch($id){
            return Year::find($id);
        }    

        public function fetchYears($id){
            return Year::where('id_type', $id)->get();
        }  

        public function update($data){
            return $data->save();
        } 

        public function delete($id){
            return Year::find($id)->delete();
        }
    }
?>