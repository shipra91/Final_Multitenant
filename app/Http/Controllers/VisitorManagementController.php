<?php

namespace App\Http\Controllers;

use App\Models\VisitorManagement;
use App\Services\VisitorManagementService;
use Illuminate\Http\Request;
use DataTables;

class VisitorManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $visitorManagementService = new VisitorManagementService();

        $input = \Arr::except($request->all(),array('_token', '_method'));

        if ($request->ajax()){
            $visitorData = $visitorManagementService->getAll($input);
            // dd($visitorData);
            return Datatables::of($visitorData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';

                        if($row->visiting_status === 'PENDING'){

                            $btn .= '<a href="/visitor/'.$row['id'].'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                            <a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Cancel Meeting" class="text-danger cancel_meeting"><i class="material-icons">cancel</i></a>
                            <a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Meeting Completed" class="text-success meeting_complete"><i class="material-icons">check_circle</i></a>
                            <a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';

                        }else{

                            $btn .= '<a href="/visitor-detail/'.$row['id'].'" type="button" rel="tooltip" title="View" class="text-warning"><i class="material-icons">account_box</i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('VisitorManagement/index')->with('page', 'visitor');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('VisitorManagement/addVisitor')->with('page', 'visitor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $visitorManagementService = new VisitorManagementService();

        $result = ["status" => 200];

        try{

            $result['data'] = $visitorManagementService->add($request);

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
     * @param  \App\Models\VisitorManagement  $visitorManagement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visitorManagementService = new VisitorManagementService();
        $visitorData = $visitorManagementService->fetch($id);

        return view('VisitorManagement/visitorDetail', ['visitorData' => $visitorData])->with('page', 'visitor');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VisitorManagement  $visitorManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visitorManagementService = new VisitorManagementService();
        $visitorData = $visitorManagementService->fetch($id);

        return view('VisitorManagement/editVisitor', ['visitorData' => $visitorData])->with('page', 'visitor');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VisitorManagement  $visitorManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $visitorManagementService = new VisitorManagementService();

        $result = ["status" => 200];

        try{

            $result['data'] = $visitorManagementService->update($request, $id);

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
     * @param  \App\Models\VisitorManagement  $visitorManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visitorManagementService = new VisitorManagementService();

        $result = ["status" => 200];

        try{

            $result['data'] = $visitorManagementService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Cancel visitor meeting
    public function cancelVisit(Request $request, $id){

        $visitorManagementService = new VisitorManagementService();

        $result = ["status" => 200];

        try{

            $result['data'] = $visitorManagementService->cancelVisit($request, $id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Complete visitor meeting
    public function meetingComplete(Request $request, $id){

        $visitorManagementService = new VisitorManagementService();

        $result = ["status" => 200];

        try{

            $result['data'] = $visitorManagementService->meetingComplete($request, $id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

     // Deleted visitor records
     public function getDeletedRecords(Request $request){

        $visitorManagementService = new VisitorManagementService();
        //dd($visitorManagementService->getDeletedRecords());

        if ($request->ajax()){
            $deletedData = $visitorManagementService->getDeletedRecords();
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('VisitorManagement/view_deleted_record')->with("page", "visitor-delete-records");
    }

    // Restore visitor records
    public function restore($id)
    {
        $visitorManagementService = new VisitorManagementService();

        $result = ["status" => 200];

        try{

            $result['data'] = $visitorManagementService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
