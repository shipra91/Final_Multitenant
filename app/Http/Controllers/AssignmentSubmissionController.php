<?php

namespace App\Http\Controllers;

use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use App\Services\AssignmentSubmissionService;
use App\Http\Requests\StoreAssignmentSubmissionRequest;
use DataTables;
use Session;

class AssignmentSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $assignmentSubmissionService = new AssignmentSubmissionService();
        $idStudent = Session::get('userId');

        $allSessions = session()->all();

        if($request->ajax()){
            $assignmentSubmission = $assignmentSubmissionService->getAll($idStudent, $allSessions);
            return Datatables::of($assignmentSubmission)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $label = '';

                        if($row['submission_type'] == 'ONLINE'){

                            if($row['resubmission'] == 'show'){
                                $label = 'Re-Upload Files';
                            }else{
                                $label = 'Upload Files';
                            }

                            if($row['submission'] == 'show' || $row['resubmission'] == 'show'){

                                $submission = '<a href="javascript:void();" data-id="'.$row['id'].'" rel="tooltip" title="'.$label.'" class="text-success assignmentSubmissionDetail"><i class="material-icons">file_upload</i></a>';

                            }else{
                                $submission = '';
                            }
                        }

                        if($row['submitted'] == 'YES'){

                            $valuationDetails = '<a href="javascript:void();" data-id="'.$row['id'].'" student-id="'.$row['id_student'].'"  rel="tooltip" title="View Mark And Comment" class="text-warning valuationDetails"><i class="material-icons">check_circle</i></a>
                            <a href="/assignment-download/'.$row['id'].'/student" rel="tooltip" title="Download Files" class="text-success" target="_blank"><i class="material-icons">file_download</i></a>';

                        }else{
                            $valuationDetails = '';
                        }

                        // $btn = '<a href="javascript:void();" data-id="'.$row['id'].'" rel="tooltip" title="View" class="text-info assignmentDetail"><i class="material-icons">visibility</i></a>
                        $btn = '<a href="/assignment-detail/'.$row['id'].'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>

                        '.$submission.'
                        '.$valuationDetails.' ';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('AssignmentSubmission/index')->with("page", "assignment_submission");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreAssignmentSubmissionRequest $request)
    {
        $assignmentSubmissionService = new AssignmentSubmissionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $assignmentSubmissionService->add($request);

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
     * @param  \App\Models\AssignmentSubmission  $assignmentSubmission
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request)
    {
        $studentAssignmentDetails = '';
        $assignmentSubmissionService = new AssignmentSubmissionService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $studentAssignmentDetails = $assignmentSubmissionService->getStudentAssignment(request()->route()->parameters['id'], $allSessions);
            return Datatables::of($studentAssignmentDetails)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        if($row['status'] == 'submitted'){

                            $btn = '<a href="/assignment-submission-download/'.$row['id'].'/'.$row['id_assignment'].'" rel="tooltip" title="Download Submitted Files" class="text-info" target="_blank"><i class="material-icons">file_download</i></a>

                            <a href="javascript:void();" data-id="'.$row['id'].'" assignment-id="'.$row['id_assignment'].'" rel="tooltip" title="Add mark and comment" class="text-warning addMarkComment"><i class="material-icons">edit</i></a>
                            ';

                        }else if($row['status'] == 'due-date-crossed'){

                            $btn = '<a href="javascript:void();" data-id="'.$row['id'].'" assignment-id="'.$row['id_assignment'].'" rel="tooltip" title="Give Resubmission Permission" class="text-warning giveResubmissionPermission"><i class="material-icons">edit</i></a>
                            ';

                        }else{

                            $btn = 'Not Submitted';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Assignments/viewStudentAssignment')->with("page", "assignment_submission");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssignmentSubmission  $assignmentSubmission
     * @return \Illuminate\Http\Response
     */
    public function edit(AssignmentSubmission $assignmentSubmission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssignmentSubmission  $assignmentSubmission
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $assignmentSubmissionService = new AssignmentSubmissionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $assignmentSubmissionService->update($request, $id);

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
     * @param  \App\Models\AssignmentSubmission  $assignmentSubmission
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssignmentSubmission $assignmentSubmission)
    {
        //
    }

    public function downloadAssignmentSubmittedFiles($idStudent, $idAssignment)
    {
        $assignmentSubmissionService = new AssignmentSubmissionService();
        return $assignmentSubmissionService->downloadAssignmentSubmittedFiles($idStudent, $idAssignment);
    }

    public function getAssignmentValuationDetails(Request $request)
    {
        $assignmentSubmissionService = new AssignmentSubmissionService();
        $allSessions = session()->all();

        return $assignmentSubmissionService->fetchAssignmentValuationDetails($request, $allSessions);

    }

    public function getAssignmentVerifiedDetails(Request $request)
    {
        $assignmentSubmissionService = new AssignmentSubmissionService();
        $allSessions = session()->all();
        
        return $assignmentSubmissionService->fetchAssignmentVerifiedDetails($request, $allSessions);
    }
}
