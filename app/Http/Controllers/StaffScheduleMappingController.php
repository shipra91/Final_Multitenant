<?php

namespace App\Http\Controllers;

use App\Models\StaffScheduleMapping;
use Illuminate\Http\Request;
use App\Services\StaffScheduleMappingService;

class StaffScheduleMappingController extends Controller
{
    /**
     *
     * create Constructor to use the functions defined in the repositories
     */
    protected $staffScheduleMappingService;
    public function __construct(StaffScheduleMappingService $staffScheduleMappingService)
    {
        $this->staffScheduleMappingService = $staffScheduleMappingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // $getData = $this->staffScheduleMappingService->getData($id);
        // // dd($getData);
        // return response()->json($getData);

        $staffSchedules = $this->staffScheduleMappingService->getData($id);
        // dd($staffSchedules["Monday"]);
        $daysArray = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return view('Staff/staffSchedule', ['staffSchedules' => $staffSchedules, 'daysArray' => $daysArray, "staffId"=>$id])->with("page", "staff");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = ["status" => 200];

        try{

            $result['data'] = $this->staffScheduleMappingService->add($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StaffScheduleMapping  $staffScheduleMapping
     * @return \Illuminate\Http\Response
     */
    public function show(StaffScheduleMapping $staffScheduleMapping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaffScheduleMapping  $staffScheduleMapping
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffScheduleMapping $staffScheduleMapping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaffScheduleMapping  $staffScheduleMapping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $result = ["status" => 200];

        try{

            $result['data'] = $this->staffScheduleMappingService->update($request, $id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StaffScheduleMapping  $staffScheduleMapping
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = ["status" => 200];

        try{

            $result['data'] = $this->staffScheduleMappingService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
