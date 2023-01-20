<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Services\StaffService;
use App\Services\StudentService;
use DataTables;
use ZipArchive;
use Helper;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $eventService = new EventService();
        //dd($eventService->getAll());
        if($request->ajax()){
            $eventData = $eventService->getAll();
            return Datatables::of($eventData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('event', 'edit')){
                            $btn .= '<a href="/event/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('event', 'view')){
                            $btn .='<a href="/event-details/'.$row['id'].'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>';

                            if($row['status'] == 'file_found'){
                                $btn .= '<a href="/event-download/'.$row['id'].'" rel="tooltip" title="Download Files" class="text-success" target="_blank"><i class="material-icons">file_download</i></a>';
                            }
                        }
                        if(Helper::checkAccess('event', 'create')){

                            if($row['attendance_required'] == 'YES'){
                                $btn .='<a href="/event-attendance/'.$row['id'].'" rel="tooltip" title="Event Attendance" class="text-warning"><i class="material-icons">account_box</i></a>';
                            }
                        }
                        if(Helper::checkAccess('event', 'delete')){
                            $btn .='<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Events/index')->with("page", "event");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $eventService = new EventService();
        $eventdata = $eventService->getEventData();

        return view('Events/events', ['eventdata' => $eventdata])->with("page", "event");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $eventService = new EventService();

        $result = ["status" => 200];

        try{

            $result['data'] = $eventService->add($request);

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
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $eventService = new EventService();

        $eventData = $eventService->getEventData();
        $selectedData = $eventService->getEventSelectedData($id);
        // dd($selectedData);
        return view('Events/viewEvent', ['eventData' => $eventData, 'selectedData' => $selectedData])->with("page", "event");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $eventService = new EventService();

        $eventData = $eventService->getEventData();
        $selectedData = $eventService->getEventSelectedData($id);
        // dd($selectedData);
        return view('Events/editEvent', ['eventData' => $eventData, 'selectedData' => $selectedData])->with("page", "event");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $eventService = new EventService();

        $result = ["status" => 200];

        try{

            $result['data'] = $eventService->update($request, $id);

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
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eventService = new EventService();

        $result = ["status" => 200];

        try{

            $result['data'] = $eventService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Get subjects based on standard
    public function getAllSubjects(Request $request)
    {
        $eventService = new EventService();

        $standardId = $request->standardId;
        $subjects = $eventService->allSubject($standardId);
        //dd($subjects);
        return $subjects;
    }

    // Get staff based on staffcategory and staffsubcategory
    public function getAllStaff(Request $request)
    {
        $staffService = new StaffService();

        $staffCategory = $request->catId;
        $staffSubcategory = $request->subCatId;

        $staffData = $staffService->getAllStaff($staffCategory, $staffSubcategory);
        // dd($staffData);
        return $staffData;
    }

    // Get all student based on standard and subject
    public function getAllStudent(Request $request)
    {
        $studentService = new StudentService();

        $studentData = $studentService->getAllStudent($request);

        return $studentData;
    }

    // Download event attachment zip
    public function downloadEventFiles($id)
    {
        $eventService = new EventService();

        $eventAttachment = $eventService->downloadEventFiles($id);
        // dd($eventAttachment);
        return $eventAttachment;
    }

    // Deleted event records
    public function getDeletedRecords(Request $request)
    {
        $eventService = new EventService();
        //dd($eventService->getDeletedRecords());
        if($request->ajax()){
            $deletedData = $eventService->getDeletedRecords();
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn ='';
                        if(Helper::checkAccess('event', 'create')){
                            $btn .= '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        }else{
                            $btn .= 'No Access';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Events/view_deleted_record')->with("page", "event");
    }

    // Restore event records
    public function restore($id)
    {
        $eventService = new EventService();

        $result = ["status" => 200];

        try{

            $result['data'] = $eventService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
