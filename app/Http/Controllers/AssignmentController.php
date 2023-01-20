<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Services\AssignmentService;
use App\Services\InstitutionStandardService;
use App\Services\StandardSubjectService;
use App\Http\Requests\StoreAssignmentRequest;
use App\Repositories\AssignmentDetailRepository;
use App\Repositories\AssignmentRepository;
use DataTables;
use ZipArchive;
use Helper;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $assignmentService = new AssignmentService();

        if($request->ajax()){
            $assignment = $assignmentService->getAll();
            // dd($assignment);
            return Datatables::of($assignment)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('assignment', 'edit')){
                            $btn .= '<a href="/assignment/'.$row['id'].'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('assignment', 'view')){
                            $btn .= '<a href="/assignment-detail/'.$row['id'].'" rel="tooltip" title="View" class="text-info assignmentDetail"><i class="material-icons">visibility</i></a>';

                            if($row['status'] == 'file_found'){
                                $btn .= '<a href="/assignment-download/'.$row['id'].'/staff_admin" rel="tooltip" title="Download Files" class="text-success" target="_blank"><i class="material-icons">file_download</i></a>';
                            }
                        }
                        if(Helper::checkAccess('assignment', 'delete')){
                            $btn .= '<a href="/assignment-submission-student/'.$row['id'].'" type="button" rel="tooltip" title="Submission Details" class="text-warning"><i class="material-icons">account_box</i></a>';
                        }
                        if(Helper::checkAccess('assignment', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Assignments/index')->with("page", "assignment");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institutionStandardService = new InstitutionStandardService();

        $standards = $institutionStandardService->fetchStaffStandard();
        return view('Assignments/addAssignment', ['standards' => $standards])->with("page", "assignment");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssignmentRequest $request)
    {
        $assignmentService = new AssignmentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $assignmentService->add($request);

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
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignmentService = new AssignmentService();

        $assignment = $assignmentService->getAssignmentSelectedData($id);
        $assignmentDetails = $assignmentService->getDetails($assignment['assignmentData']);
        //dd($assignment);
        return view('Assignments/viewAssignmentDetail', ["assignment" => $assignment, 'assignmentDetails' => $assignmentDetails])->with("page", "assignment");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $assignmentService = new AssignmentService();

        $assignment = $assignmentService->getAssignmentSelectedData($id);
        $assignmentDetails = $assignmentService->getDetails($assignment['assignmentData']);
        //dd($assignment);
        return view('Assignments/editAssignment', ["assignment" => $assignment, 'assignmentDetails' => $assignmentDetails])->with("page", "assignment");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $assignmentService = new AssignmentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $assignmentService->update($request, $id);

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
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assignmentService = new AssignmentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $assignmentService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Get all subject based on standard
    public function getSubjects(Request $request)
    {
        $assignmentService = new AssignmentService();

        $standardId = $request->standardId;
        // return $standardSubjectService->getStandardsSubject($standardId);
        return $assignmentService->allSubject($standardId);
    }

    public function getAssignmentDetails(Request $request)
    {
        $assignmentService = new AssignmentService();
        return $assignmentService->fetchDetails($request);
    }

    // Download assignment attachment zip
    public function downloadAssignmentFiles($id, $type)
    {
        $assignmentService = new AssignmentService();
        return $assignmentService->downloadAssignmentFiles($id, $type);
    }

    // Deleted assignment records
    public function getDeletedRecords(Request $request)
    {
        $assignmentService = new AssignmentService();

        if($request->ajax()){
            $deletedData = $assignmentService->getDeletedRecords();
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn ='';
                        if(Helper::checkAccess('assignment', 'create')){
                            $btn .= '<button type="button" data-id="'.$row->id.'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        }else{
                            $btn .= 'No Access';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Assignments/viewDeletedRecord')->with("page", "assignment");
    }

    // Restore assignment records
    public function restore($id)
    {
        $assignmentService = new AssignmentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $assignmentService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // public function restoreAll()
    // {
    //     $assignmentService = new AssignmentService();

    //     $result = ["status" => 200];

    //     try{

    //         $result['data'] = $assignmentService->restoreAll();

    //     }catch(Exception $e){

    //         $result = [
    //             "status" => 500,
    //             "error" => $e->getMessage()
    //         ];
    //     }

    //     return response()->json($result, $result['status']);
    // }
}
