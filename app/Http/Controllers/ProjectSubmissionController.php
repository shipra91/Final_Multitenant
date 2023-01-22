<?php

namespace App\Http\Controllers;

use App\Models\ProjectSubmission;
use Illuminate\Http\Request;
use App\Services\ProjectSubmissionService;
use App\Http\Requests\StoreProjectSubmissionRequest;
use DataTables;

class ProjectSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projectSubmissionService = new ProjectSubmissionService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $projectSubmission = $projectSubmissionService->getAll($allSessions);
            return Datatables::of($projectSubmission)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $label = '';

                        if($row['submission_type'] == 'ONLINE'){

                            if($row['resubmission'] == 'show'){
                                $label = 'Re-Upload Files';
                            }else{
                                $label = 'Upload Files';
                            }

                            if($row['submission'] == 'show' || $row['resubmission'] == 'show' ){
                                $submission = '<a href="javascript:void();" data-id="'.$row['id'].'" rel="tooltip" title="'.$label.'"class="text-success projectSubmissionDetail"><i class="material-icons">file_upload</i></a>';
                            }else{
                                $submission = '';
                            }
                        }

                        if($row['submitted'] == 'YES'){
                            $valuationDetails = '<a href="javascript:void();" data-id="'.$row['id'].'" student-id="'.$row['id_student'].'"  rel="tooltip" title="View Mark And Comment" class="text-warning valuationDetails"><i class="material-icons">check_circle</i></a>';
                        }else{
                            $valuationDetails = '';
                        }

                        $btn = '<a href="javascript:void();" data-id="'.$row['id'].'"  rel="tooltip" title="View" class="text-info projectDetail"><i class="material-icons">visibility</i></a>

                        <a href="/project-download/'.$row['id'].'/student" rel="tooltip" title="Download Files" class="text-success" target="_blank"><i class="material-icons">file_download</i></a>
                        '.$submission.'
                        '.$valuationDetails.' ';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('ProjectSubmission/index')->with("page", "project_submission");
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
    public function store(StoreProjectSubmissionRequest $request)
    {
        $projectSubmissionService = new ProjectSubmissionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $projectSubmissionService->add($request);

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
     * @param  \App\Models\ProjectSubmission  $projectSubmission
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $studentProjectDetails = '';
        $projectSubmissionService = new ProjectSubmissionService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $studentProjectDetails = $projectSubmissionService->getStudentProject(request()->route()->parameters['id'], $allSessions);

            return Datatables::of($studentProjectDetails)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        if($row['status'] == 'submitted'){
                            $btn = '<a href="/project-submission-download/'.$row['id'].'/'.$row['id_project'].'" rel="tooltip" title="Download Submitted Files" class="text-success" target="_blank"><i class="material-icons">file_download</i></a>
                            <a href="javascript:void();" data-id="'.$row['id'].'" project-id="'.$row['id_project'].'" rel="tooltip" title="Add mark and comment" class="text-warning addMarkComment"><i class="material-icons">edit</i></a>
                            ';

                        }else if($row['status'] == 'due-date-crossed'){
                            $btn = '<a href="javascript:void();" data-id="'.$row['id'].'" project-id="'.$row['id_project'].'" rel="tooltip" title="Give Resubmission Permission" class="text-warning giveResubmissionPermission"><i class="material-icons">edit</i></a>
                            ';

                        }else{
                            $btn = 'Not Submitted';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Projects/viewStudentProject')->with("page", "project_submission");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectSubmission  $projectSubmission
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectSubmission $projectSubmission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectSubmission  $projectSubmission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $projectSubmissionService = new ProjectSubmissionService();
        $result = ["status" => 200];

        try{

            $result['data'] = $projectSubmissionService->update($request, $id);

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
     * @param  \App\Models\ProjectSubmission  $projectSubmission
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectSubmission $projectSubmission)
    {
        //
    }

    public function downloadProjectSubmittedFiles($idStudent, $idProject)
    {
        $projectSubmissionService = new ProjectSubmissionService();
        return $projectSubmissionService->downloadProjectSubmittedFiles($idStudent, $idProject);
    }

    public function getProjectValuationDetails(Request $request){

        $projectSubmissionService = new ProjectSubmissionService();
        $allSessions = session()->all();

        return $projectSubmissionService->fetchProjectValuationDetails($request, $allSessions);

    }
    public function getProjectVerifiedDetails(Request $request){

        $projectSubmissionService = new ProjectSubmissionService();
        $allSessions = session()->all();

        return $projectSubmissionService->fetchProjectVerifiedDetails($request, $allSessions);

    }
}
