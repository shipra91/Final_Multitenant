<?php

namespace App\Http\Controllers;

use App\Models\HomeworkSubmission;
use Illuminate\Http\Request;
use App\Services\HomeworkSubmissionService;
use App\Http\Requests\StoreHomeworkSubmissionRequest;
use DataTables;

class HomeworkSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $homeworkSubmissionService = new HomeworkSubmissionService();
        //dd($homeworkSubmissionService->getAll());
        if($request->ajax()){
            $homeworkSubmission = $homeworkSubmissionService->getAll();
            return Datatables::of($homeworkSubmission)
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
                                $submission = '<a href="javascript:void();" data-id="'.$row['id'].'" rel="tooltip" title="'.$label.'" class="text-success homeworkSubmissionDetail"><i class="material-icons">file_upload</i></a>';
                            }else{
                                $submission = '';
                            }
                        }

                        if($row['submitted'] == 'YES'){
                            $valuationDetails = '<a href="javascript:void();" data-id="'.$row['id'].'" student-id="'.$row['id_student'].'"  rel="tooltip" title="View Mark And Comment" class="text-warning valuationDetails"><i class="material-icons">check_circle</i></a>';
                        }else{
                            $valuationDetails = '';
                        }

                        $btn = '<a href="javascript:void();" data-id="'.$row['id'].'"  rel="tooltip" title="View" class="text-info homeworkDetail"><i class="material-icons">visibility</i></a>
                        <a href="/homework-download/'.$row['id'].'/student" rel="tooltip" title="Download Files" class="text-success" target="_blank"><i class="material-icons">file_download</i></a>
                        '.$submission.'
                        '.$valuationDetails.' ';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('HomeworkSubmission/index')->with("page", "homework_submission");
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
    public function store(StoreHomeworkSubmissionRequest $request)
    {
        $homeworkSubmissionService = new HomeworkSubmissionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $homeworkSubmissionService->add($request);

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
     * @param  \App\Models\HomeworkSubmission  $homeworkSubmission
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $homeworkSubmissionService = new HomeworkSubmissionService();

        $studentHomeworkDetails = '';

        if($request->ajax()){
            $studentHomeworkDetails = $homeworkSubmissionService->getStudentHomework(request()->route()->parameters['id']);
            return Datatables::of($studentHomeworkDetails)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        if($row['status'] == 'submitted'){

                            $btn = '<a href="/homework-submission-download/'.$row['id'].'/'.$row['id_homework'].'" rel="tooltip" title="Download Submitted Files" class="text-info" target="_blank"><i class="material-icons">file_download</i></a>
                            <a href="javascript:void();" data-id="'.$row['id'].'" homework-id="'.$row['id_homework'].'" rel="tooltip" title="Add mark and comment" class="text-warning addMarkComment"><i class="material-icons">edit</i></a>';

                        }else if($row['status'] == 'due-date-crossed'){

                            $btn = '<a href="javascript:void();" data-id="'.$row['id'].'" homework-id="'.$row['id_homework'].'" rel="tooltip" title="Give Resubmission Permission" class="text-warning giveResubmissionPermission"><i class="material-icons">edit</i></a>';

                        }else{
                            $btn = 'Not Submitted';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Homework/viewStudentHomework')->with("page", "homework_submission");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeworkSubmission  $homeworkSubmission
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeworkSubmission $homeworkSubmission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeworkSubmission  $homeworkSubmission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $homeworkSubmissionService = new HomeworkSubmissionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $homeworkSubmissionService->update($request, $id);

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
     * @param  \App\Models\HomeworkSubmission  $homeworkSubmission
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeworkSubmission $homeworkSubmission)
    {
        //
    }

    public function downloadHomeworkSubmittedFiles($idStudent, $idHomework)
    {
        $homeworkSubmissionService = new HomeworkSubmissionService();
        return $homeworkSubmissionService->downloadHomeworkSubmittedFiles($idStudent, $idHomework);
    }

    public function getHomeworkValuationDetails(Request $request)
    {
        $homeworkSubmissionService = new HomeworkSubmissionService();
        return $homeworkSubmissionService->fetchHomeworkValuationDetails($request);
    }

    public function getHomeworkVerifiedDetails(Request $request)
    {
        $homeworkSubmissionService = new HomeworkSubmissionService();
        return $homeworkSubmissionService->fetchHomeworkVerifiedDetails($request);
    }
}
