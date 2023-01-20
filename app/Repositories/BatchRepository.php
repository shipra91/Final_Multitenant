<?php
    namespace App\Repositories;
    use App\Models\Batch;
    use App\Models\BatchDetail;
    use App\Interfaces\BatchRepositoryInterface;
    use DB;
    use Session;

    class BatchRepository implements BatchRepositoryInterface {

        public function all($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            return Batch::where('id_institute', $institutionId)
                        ->where('id_academic', $academicYear)
                        ->get();
        }

        public function store($data){
            return Batch::create($data);
        }

        public function fetch($id){
            return Batch::find($id);
        }

        // public function update($data, $id){
        //     return Batch::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return Batch::find($id)->delete();
        }

        public function fetchBatchNoByStandard($standardId, $allSessions){
            //\DB::enableQueryLog();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $data = Batch::where('id_institute', $institutionId)
                        ->where('id_academic', $academicYear)
                        ->where('id_standard', $standardId)
                        ->first();

            if($data){
                $no_of_column = $data->no_of_batch;
            }else{
                $no_of_column = 0;
            }
            //dd(\DB::getQueryLog());
            return $no_of_column;
        }

        // Get batch details
        public function getBatchDetails($idStandard, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            //\DB::enableQueryLog();
            $data = BatchDetail::join('tbl_batch', 'tbl_batch.id', '=', 'tbl_batch_detail.id_batch')
                                            ->where('tbl_batch.id_institute', $institutionId)
                                            ->where('tbl_batch.id_academic', $academicYear)
                                            ->where('tbl_batch.id_standard', $idStandard)
                                            ->get(['tbl_batch_detail.*']);
            //dd(\DB::getQueryLog());
            return $data;
        }
    }
?>
