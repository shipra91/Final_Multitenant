<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Services\SeminarService;
use DataTables;
use Helper;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $seminarService = new SeminarService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $seminars = $seminarService->getAll($allSessions);
            return Datatables::of($seminars)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('seminar', 'edit')){
                            $btn ='<a href="/seminar/'.$row->id.'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('seminar', 'view')){
                            $btn .= '<a href="javascript:void();" data-id="'.$row->id.'" rel="tooltip" title="View" class="text-info seminarDetail"><i class="material-icons">visibility</i></a>
                            <a href="/seminar-download/'.$row->id.'/staff_admin" rel="tooltip" title="Download Files" class="text-success" target="_blank"><i class="material-icons">file_download</i></a>
                            <a href="/seminar-conductors/'.$row->id.'" type="button" rel="tooltip" title="Submission Details" class="text-warning"><i class="material-icons">account_box</i></a>';
                        }
                        if(Helper::checkAccess('seminar', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Seminar/index')->with("page", "seminar");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $eventService = new EventService();
        $allSessions = session()->all();

        $details = $eventService->getEventData($allSessions);
        return view('Seminar/addSeminar', ['details' => $details])->with("page", "seminar");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seminarService = new SeminarService();
        $allSessions = session()->all();

        $result = ["status" => 200];

        try{

            $result['data'] = $seminarService->add($request, $allSessions);

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
     * @param  \App\Models\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    public function show(Seminar $seminar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seminarService = new SeminarService();
        $seminarDetails = $seminarService->getSeminarDetails($id);
        //dd($seminarDetails);

        return view('Seminar/editSeminar', ['seminarDetails' => $seminarDetails])->with("page", "seminar");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $seminarService = new SeminarService();
        $allSessions = session()->all();

        $result = ["status" => 200];

        try{

            $result['data'] = $seminarService->update($request, $id, $allSessions);

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
     * @param  \App\Models\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seminarService = new SeminarService();
        $result = ["status" => 200];

        try{

            $result['data'] = $seminarService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getSeminarDetails(Request $request){
        $seminarService = new SeminarService();
        // dd($seminarService->fetchSeminarDetails($request));
        return $seminarService->fetchSeminarDetails($request);
    }

    public function downloadSeminarFiles($id, $type)
    {
        $seminarService = new SeminarService();
        return $seminarService->downloadSeminarFiles($id, $type);
    }

    public function getDeletedRecords(Request $request){

        $seminarService = new SeminarService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $deletedData = $seminarService->getDeletedRecords($allSessions);
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Seminar/viewDeletedRecord')->with("page", "seminar");
    }

    public function restore($id)
    {
        $seminarService = new SeminarService();

        $result = ["status" => 200];

        try{

            $result['data'] = $seminarService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function restoreAll()
    {
        $seminarService = new SeminarService();

        $result = ["status" => 200];

        try{

            $result['data'] = $seminarService->restoreAll();

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
