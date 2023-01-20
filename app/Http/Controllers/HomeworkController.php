<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use Illuminate\Http\Request;
use App\Services\HomeworkService;
use App\Services\InstitutionStandardService;
use App\Services\StandardSubjectService;
use App\Http\Requests\StoreHomeworkRequest;
use App\Repositories\HomeworkDetailRepository;
use App\Repositories\HomeworkRepository;
use DataTables;
use ZipArchive;
use Helper;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $homeworkService = new HomeworkService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $homework = $homeworkService->getAll($allSessions);
            return Datatables::of($homework)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '';

                        if($row['status'] == 'file_found'){
                            $download = '<a href="/homework-download/'.$row['id'].'/staff_admin" rel="tooltip" title="Download Files" class="text-success" target="_blank"><i class="material-icons">file_download</i></a>';
                        }else {
                            $download = '';
                        }

                        if(Helper::checkAccess('homework', 'edit')){
                            $btn .= '<a href="/homework/'.$row['id'].'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('homework', 'view')){
                            $btn .='<a href="javascript:void();" data-id="'.$row['id'].'" rel="tooltip" title="View" class="text-info homeworkDetail"><i class="material-icons">visibility</i></a>';
                        }
                        if(Helper::checkAccess('homework', 'view')){
                            $btn .= $download;
                        }
                        if(Helper::checkAccess('homework', 'view')){
                            $btn .='<a href="/homework-submission-student/'.$row['id'].'" type="button" rel="tooltip" title="Submission Details" class="text-warning"><i class="material-icons">account_box</i></a>';
                        }
                        if(Helper::checkAccess('homework', 'delete')){
                            $btn .='<a href="javascript:void();" data-id="'.$row['id'].'" type="button" rel="tooltip" title="Delete" class="text-danger  delete"><i class="material-icons">delete</i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Homework/index')->with("page", "homework");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institutionStandardService = new InstitutionStandardService();
        $allSessions = session()->all();

        $standards = $institutionStandardService->fetchStaffStandard($allSessions);
        return view('Homework/addHomework', ['standards' => $standards])->with("page", "homework");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHomeworkRequest $request)
    {
        $homeworkService = new HomeworkService();

        $result = ["status" => 200];

        try{

            $result['data'] = $homeworkService->add($request);

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
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function show(Homework $homework)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $homeworkService = new HomeworkService();
        $institutionStandardService = new InstitutionStandardService();
        $allSessions = session()->all();

        $homework = $homeworkService->find($id);
        $homeworkDetails = $homeworkService->getDetails($homework, $allSessions);
        return view('Homework/editHomework', ["homework" => $homework, 'homeworkDetails' => $homeworkDetails])->with("page", "homework");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $homeworkService = new HomeworkService();

        $result = ["status" => 200];

        try{

            $result['data'] = $homeworkService->update($request, $id);

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
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $homeworkService = new HomeworkService();

        $result = ["status" => 200];

        try{

            $result['data'] = $homeworkService->delete($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getSubjects(Request $request){

        $homeworkService = new HomeworkService();
        $allSessions = session()->all();

        $standardId = $request->standardId;
        // return $standardSubjectService->getStandardsSubject($standardId);
        return $homeworkService->allSubject($standardId, $allSessions);
    }

    public function getHomeworkDetails(Request $request){

        $homeworkService = new HomeworkService();
        $allSessions = session()->all();

        return $homeworkService->fetchDetails($request, $allSessions);
    }

    public function downloadHomeworkFiles($id, $type){

        $homeworkService = new HomeworkService();
        $allSessions = session()->all();

        return $homeworkService->downloadHomeworkFiles($id, $type, $allSessions);
    }

    public function getDeletedRecords(Request $request){

        $homeworkService = new HomeworkService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $deletedData = $homeworkService->getDeletedRecords($allSessions);
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Homework/viewDeletedRecord')->with("page", "homework");
    }

    public function restore($id){

        $homeworkService = new HomeworkService();

        $result = ["status" => 200];

        try{

            $result['data'] = $homeworkService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function restoreAll(){

        $homeworkService = new HomeworkService();
        $allSessions = session()->all();

        $result = ["status" => 200];

        try{

            $result['data'] = $homeworkService->restoreAll($allSessions);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
