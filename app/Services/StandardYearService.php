<?php
namespace App\Services;
use App\Models\StandardYear;
use App\Repositories\YearRepository;
use Carbon\Carbon;
use Session;

class StandardYearService {

    // Get all standard year
    public function getAllYear(){

        $yearRepository = new YearRepository();

        $arrayYearDetails = array();
        $yearDetails = $yearRepository->all();

        foreach($yearDetails as $year){
            $arrayYearDetails[$year->id] = $year->name;
        }

        return $arrayYearDetails;
    }

    // Get particular standard year
    public function find($id){

        $yearRepository = new YearRepository();
        $year = $yearRepository->fetch($id);

        return $year;
    }

    public function getStandardYearData(){

        $yearRepository = new YearRepository();

        return $yearRepository->all();
    }

    // Insert standard year
    public function add($standardYearData){

        $yearRepository = new YearRepository();
        $check = StandardYear::where('name', $standardYearData->standardYear)->first();

        if(!$check){

            $data = array(
                'name' => $standardYearData->standardYear,
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );

            $storeData = $yearRepository->store($data);

            if($storeData) {
                $signal = 'success';
                $msg = 'Data inserted successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error inserting data!';
            }

        }else{
            $signal = 'exist';
            $msg = 'This data already exists!';
        }

        $output = array(
            'signal'=>$signal,
            'message'=>$msg
        );

        return $output;
    }

    // Update standard year
    public function update($standardYearData, $id){

        $yearRepository = new YearRepository();

        $check = StandardYear::where('name', $standardYearData->standardYear)
                            ->where('id', '!=', $id)->first();

        if(!$check){

            $standardYearDetails = $yearRepository->fetch($id);

            $standardYearDetails->name = $standardYearData->standardYear;
            $standardYearDetails->modified_by = Session::get('userId');
            $standardYearDetails->updated_at = Carbon::now();

            $updateData = $yearRepository->update($standardYearDetails);

            if($updateData) {
                $signal = 'success';
                $msg = 'Data updated successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error updating data!';
            }

        }else{
            $signal = 'exist';
            $msg = 'This data already exists!';
        }

        $output = array(
            'signal'=>$signal,
            'message'=>$msg
        );

        return $output;
    }

    // Delete standard
    public function delete($id){

        $yearRepository = new YearRepository();

        $standardYear = $yearRepository->delete($id);

        if($standardYear){
            $signal = 'success';
            $msg = 'Deleted successfully!';
        }

        $output = array(
            'signal'=>$signal,
            'message'=>$msg
        );

        return $output;
    }
}
?>
