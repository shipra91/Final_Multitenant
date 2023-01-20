<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use App\Services\HolidayService;
use DataTables;
use Helper;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $holidayService = new HolidayService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $holidays = $holidayService->getAll($allSessions);
            return Datatables::of($holidays)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('holiday', 'edit')){
                            $btn = '<a href="/holiday/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('holiday', 'view')){
                            $btn .='<a href="/holiday-detail/'.$row['id'].'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>';
                        }
                        if(Helper::checkAccess('holiday', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Holidays/index')->with("page", "holiday");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $holidayService = new HolidayService();
        $allSessions = session()->all();

        $holidayData = $holidayService->getHolidayData($allSessions);

        return view('Holidays/add_holiday', ['holidayData' => $holidayData])->with("page", "holiday");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $holidayService = new HolidayService();

        $result = ["status" => 200];

        try{

            $result['data'] = $holidayService->add($request);

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
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function show(Holiday $holiday)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $holidayService = new HolidayService();
        $allSessions = session()->all();

        $holidayData = $holidayService->getHolidayData($allSessions);
        $selectedData = $holidayService->getHolidaySelectedData($id);
        // dd($selectedData);

        return view('Holidays/edit_holiday', ['holidayData' => $holidayData, 'selectedData' => $selectedData])->with("page", "holiday");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $holidayService = new HolidayService();

        $result = ["status" => 200];

        try{

            $result['data'] = $holidayService->update($request, $id);

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
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $holidayService = new HolidayService();

        $result = ["status" => 200];

        try{

            $result['data'] = $holidayService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getDeletedRecords(Request $request)
    {
        $holidayService = new HolidayService();
        $allSessions = session()->all();

        if ($request->ajax()){

            $deletedData = $holidayService->getDeletedRecords($allSessions);

            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Holidays/view_deleted_record')->with("page", "holiday");
    }

    public function restore($id){

        $holidayService = new HolidayService();

        $result = ["status" => 200];

        try{

            $result['data'] = $holidayService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getHolidayDetails($idHoliday){

        $holidayService = new HolidayService();
        $allSessions = session()->all();

        $holidayData = $holidayService->getHolidayData($allSessions);
        $selectedData = $holidayService->getHolidaySelectedData($idHoliday);
        // dd($selectedData);
        return view('Holidays/view_holiday_detail', ['holidayData' => $holidayData, 'selectedData' => $selectedData])->with("page", "holiday");
    }

    public function downloadHolidayFiles($idHoliday){

        $holidayService = new HolidayService();

        return $holidayService->downloadHolidayFiles($idHoliday);
    }
}
