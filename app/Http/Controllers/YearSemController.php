<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sem;
use App\Models\Year;
use App\Models\YearSem;
use App\Services\YearSemService;
use App\Models\StandardYear;
use App\Services\StandardYearService;
use DataTables;

class YearSemController extends Controller
{
    public function create()
    {
        $yearSemService = new YearSemService();
        $yearSemDetails = $yearSemService->getData();
       // dd($yearSemDetails);
        return view('Standard/yearSemMapping',["yearSemDetails" => $yearSemDetails ])->with("page", "year_sem_mapping");
    }

    public function getYearSemester(Request $request)
    { 
        $yearSemService = new YearSemService();
        $yearId = $request['id'];
        $semDetails = $yearSemService->getSem($yearId);
        return $semDetails;
    }

    public function store(Request $request)
    {
        $yearSemService = new YearSemService();
        $result = ["status" => 200];

        try{

            $result['data'] = $yearSemService->add($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

}
