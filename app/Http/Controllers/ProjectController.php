<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Services\InstitutionStandardService;
use App\Services\StandardSubjectService;
use App\Http\Requests\StoreProjectRequest;
use App\Repositories\ProjectDetailRepository;
use App\Repositories\ProjectRepository;
use DataTables;
use ZipArchive;
use Helper;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projectService = new ProjectService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $project = $projectService->getAll($allSessions);
            return Datatables::of($project)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';

                        if(Helper::checkAccess('project', 'edit')){
                            $btn .= '<a href="/project/'.$row['id'].'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('project', 'view')){
                            $btn .='<a href="javascript:void();" data-id="'.$row['id'].'" rel="tooltip" title="View" class="text-info projectDetail"><i class="material-icons">visibility</i></a>';
                        }
                        if($row['status'] == 'file_found'){
                            if(Helper::checkAccess('project', 'view')){
                                $btn .= '<a href="/project-download/'.$row['id'].'/staff_admin" rel="tooltip" title="Download Files" class="text-success" target="_blank"><i class="material-icons">file_download</i></a>';
                            }
                        }
                        if(Helper::checkAccess('project', 'view')){
                            $btn .= '<a href="/project-submission-student/'.$row['id'].'" type="button" rel="tooltip" title="Submission Details" class="text-warning"><i class="material-icons">account_box</i></a>';
                        }
                        if(Helper::checkAccess('project', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Projects/index')->with("page", "project");
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

       return view('Projects/addProject', ['standards' => $standards])->with("page", "project");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $projectService = new ProjectService();

        $result = ["status" => 200];

        try{

            $result['data'] = $projectService->add($request);

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
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projectService = new ProjectService();
        $institutionStandardService = new InstitutionStandardService();
        $allSessions = session()->all();

        $project = $projectService->find($id);
        $projectDetails = $projectService->getDetails($project, $allSessions);
        // dd($projectDetails);
        return view('Projects/editProject', ["project" => $project, 'projectDetails' => $projectDetails])->with("page", "project");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $projectService = new ProjectService();

        $result = ["status" => 200];

        try{

            $result['data'] = $projectService->update($request, $id);

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
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $projectService = new ProjectService();

        $result = ["status" => 200];

        try{

            $result['data'] = $projectService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getSubjects(Request $request)
    {
        $projectService = new ProjectService();
        $allSessions = session()->all();

        $standardId = $request->standardId;
        // return $standardSubjectService->getStandardsSubject($standardId);
        return $projectService->allSubject($standardId, $allSessions);
    }

    public function getProjectDetails(Request $request)
    {
        $projectService = new ProjectService();
        $allSessions = session()->all();

        return $projectService->fetchDetails($request, $allSessions);
    }

    public function downloadProjectFiles($id, $type)
    {
        $projectService = new ProjectService();
        $allSessions = session()->all();

        return $projectService->downloadProjectFiles($id, $type, $allSessions);
    }

    public function getDeletedRecords(Request $request){

        $projectService = new ProjectService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $deletedData = $projectService->getDeletedRecords($allSessions);
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Projects/viewDeletedRecord')->with("page", "project");
    }

    public function restore($id)
    {
        $projectService = new ProjectService();

        $result = ["status" => 200];

        try{

            $result['data'] = $projectService->restore($id);

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
        $projectService = new ProjectService();
        $allSessions = session()->all();

        $result = ["status" => 200];

        try{

            $result['data'] = $projectService->restoreAll($allSessions);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
