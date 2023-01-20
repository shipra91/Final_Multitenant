<?php

namespace App\Http\Controllers;

use App\Models\StudentLeaveManagement;
use App\Services\StudentLeaveManagementService;
use Illuminate\Http\Request;
use DataTables;
use ZipArchive;
use Helper;

class StudentLeaveManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $studentLeaveManagementService = new StudentLeaveManagementService();
        //dd($studentLeaveManagementService->getAll());
        if($request->ajax()){
            $applicationData = $studentLeaveManagementService->getAll();
            return Datatables::of($applicationData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if($row['leaveStatus'] !== 'Pending'){

                            if(Helper::checkAccess('leave', 'view')){
                                $btn .= '<a href="/leave-management-detail/'.$row['id'].'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>';
                            }

                        }else{

                            if(Helper::checkAccess('leave', 'edit')){
                                $btn .= '<a href="/leave-management/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                            }
                            if(Helper::checkAccess('leave', 'view')){
                                $btn .= '<a href="/leave-management-detail/'.$row['id'].'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>';

                                if($row['leaveApplicationStatus'] == 'file_found'){
                                    $btn .= '<a href="/leave-management-download/'.$row['id'].'" rel="tooltip" title="Download Files" class="text-success" target="_blank"><i class="material-icons">file_download</i></a>';
                                }
                            }
                            if(Helper::checkAccess('leave', 'delete')){
                                $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                            }
                            if(Helper::checkAccess('leave', 'view')){
                                $btn .= '<a href="javascript:void();" data-id="'.$row['id'].'" rel="tooltip" title="Approve/Reject" class="text-warning leaveApproval"><i class="material-icons">check_circle</i></a>';
                            }
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('StudentLeaveManagement/index')->with("page", "studentLeaveManagement");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $studentLeaveManagementService = new StudentLeaveManagementService();

        $studentData = $studentLeaveManagementService->allStudent();
        // dd($studentData);
        return view('StudentLeaveManagement/addStudentLeave', ['studentData' => $studentData])->with("page", "studentLeaveManagement");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $studentLeaveManagementService = new StudentLeaveManagementService();

        $result = ["status" => 200];

        try{

            $result['data'] = $studentLeaveManagementService->add($request);

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
     * @param  \App\Models\StudentLeaveManagement  $studentLeaveManagement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $studentLeaveManagementService = new StudentLeaveManagementService();

        $studentData = $studentLeaveManagementService->allStudent();
        $selectedData = $studentLeaveManagementService->getSelectedData($id);
        //dd($selectedData);
        return view('StudentLeaveManagement/viewStudentLeave', ['studentData' => $studentData, 'selectedData' => $selectedData])->with("page", "studentLeaveManagement");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentLeaveManagement  $studentLeaveManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $studentLeaveManagementService = new StudentLeaveManagementService();

        $studentData = $studentLeaveManagementService->allStudent();
        $selectedData = $studentLeaveManagementService->getSelectedData($id);
        //dd($selectedData);

        return view('StudentLeaveManagement/editStudentLeave', ['studentData' => $studentData, 'selectedData' => $selectedData])->with("page", "studentLeaveManagement");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentLeaveManagement  $studentLeaveManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $studentLeaveManagementService = new StudentLeaveManagementService();

        $result = ["status" => 200];

        try{

            $result['data'] = $studentLeaveManagementService->update($request, $id);

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
     * @param  \App\Models\StudentLeaveManagement  $studentLeaveManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $studentLeaveManagementService = new StudentLeaveManagementService();

        $result = ["status" => 200];

        try{

            $result['data'] = $studentLeaveManagementService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Deleted leave application records
    public function getDeletedRecords(Request $request){

        $studentLeaveManagementService = new StudentLeaveManagementService();
        //dd($studentLeaveManagementService->getDeletedRecords());

        if($request->ajax()){
            $deletedData = $studentLeaveManagementService->getDeletedRecords();
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('leave', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('StudentLeaveManagement/view_deleted_record')->with("page", "studentLeaveManagement");
    }

    // Restore leave application records
    public function restore($id)
    {
        $studentLeaveManagementService = new StudentLeaveManagementService();

        $result = ["status" => 200];

        try{

            $result['data'] = $studentLeaveManagementService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Download leave application attachment zip
    public function downloadLeaveFiles($id)
    {
        $studentLeaveManagementService = new StudentLeaveManagementService();

        $applicationAttachment = $studentLeaveManagementService->downloadLeaveApplicationFiles($id);
        // dd($applicationAttachment);
        return $applicationAttachment;
    }

    // Update leave approval
    public function storeLeaveApproval(Request $request, $id){

        $studentLeaveManagementService = new StudentLeaveManagementService();

        $result = ["status" => 200];

        try{

            $result['data'] = $studentLeaveManagementService->leaveApproval($request, $id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
