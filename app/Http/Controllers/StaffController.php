<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use App\Services\StaffService;
use App\Services\CustomFieldService;
use App\Services\SubjectService;
use App\Services\StaffSubjectMappingService;
use App\Services\StaffBoardService;
use App\Services\InstitutionBoardService;
use App\Services\InstitutionSubjectService;
use App\Http\Requests\StoreStaffRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportStaff;
use App\Exports\ExportStaffSample;
use DataTables;
use Helper;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $staffService = new StaffService();
        $input = \Arr::except($request->all(),array('_token', '_method'));
        $allColumns = $staffService->getTableColumns();
        $allSessions = session()->all();

        $staffDetails = $staffService->getStaffData();
        $daysArray = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        if ($request->ajax()){

            $Staff = $staffService->getAll($input, $allSessions);

            return Datatables::of($Staff)
                    ->addIndexColumn()
                    ->editColumn('show', function ($Staff){
                        return  ($Staff->working_hours == 'PART_TIME')?"Part Time":"Full Time";
                    })
                    ->addColumn('action', function($row){
                        $btn = '';

                        if(Helper::checkAccess('staff', 'edit')){
                            $btn .= '<a href="/staff/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('staff', 'view')){
                            $btn .='<a href="/staff-detail/'.$row['id'].'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>';
                        }
                        if(Helper::checkAccess('staff', 'create')){
                            if($row['working_hours'] == 'PART_TIME'){
                                $btn .= '<a href="/staff-schedule/'.$row['id'].'" rel="tooltip" title="Working Hours" class="text-warning ml-5"><i class="material-icons">watch_later</i></a>';
                            }
                        }
                        if(Helper::checkAccess('staff', 'delete')){
                            $btn .= '<a href="javascript:void(0);" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Staff/index', ['staffDetails' => $staffDetails, 'daysArray' => $daysArray, 'allColumns' => $allColumns])->with("page", "staff");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institutionBoardService = new InstitutionBoardService();
        $institutionSubjectService = new InstitutionSubjectService();
        $customFieldService = new CustomFieldService();
        $staffService = new StaffService();
        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];

        $institutionBoards = $institutionBoardService->getInstitutionBoards($institutionId);
        $staffDetails = $staffService->getStaffData();
        $subjects = $institutionSubjectService->getAll($allSessions);
        $customFields = $customFieldService->fetchRequiredCustomFields($institutionId, 'staff');
        // dd($subjects);


        return view('Staff/addStaff', ["staffDetails" => $staffDetails, "customFields" => $customFields, "subjects" => $subjects, 'institutionBoards' => $institutionBoards])->with("page", "staff");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStaffRequest $request)
    {
        $staffService = new StaffService();
        $result = ["status" => 200];

        try{

            $result['data'] = $staffService->add($request);

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
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staffService = new StaffService();
        $allSessions = session()->all();

        $staffData = $staffService->find($id, $allSessions);
        $customFieldDetails = $staffService->fetchCustomFieldValues($id);
        $customFileDetails = $staffService->fetchCustomFileValues($id);
        return view('Staff/viewStaff', ["staffData" => $staffData, "customFieldDetails" => $customFieldDetails, "customFileDetails" => $customFileDetails])->with("page", "staff");
        //dd($staffData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institutionBoardService = new InstitutionBoardService();
        $staffBoardService = new StaffBoardService();
        $staffSubjectMappingService = new StaffSubjectMappingService();
        $customFieldService = new CustomFieldService();
        $subjectService = new SubjectService();
        $institutionSubjectService = new InstitutionSubjectService();
        $staffService = new StaffService();
        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];

        $selectedStaff = $staffService->find($id, $allSessions);
        $staffDetails = $staffService->getStaffData();
        $subjects = $institutionSubjectService->getAll($allSessions);
        $subjectMapping = $staffSubjectMappingService->getAllIds($id);
        $staffBoard = $staffBoardService->getAllIds($id);
        $institutionBoards = $institutionBoardService->getInstitutionBoards($institutionId);
        $customFields = $customFieldService->getCustomFieldsEdit($institutionId, 'staff', 'id_staff', $id, 'App\Models\StaffCustomDetails');
        
        return view('Staff/editStaff', ["selectedStaff" => $selectedStaff, "staffDetails" => $staffDetails, "customFields" => $customFields, "subjects" => $subjects, "subjectMapping" => $subjectMapping, "staffBoard" => $staffBoard, 'institutionBoards'=> $institutionBoards])->with("page", "staff");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(StoreStaffRequest $request, $id)
    {
        $staffService = new StaffService();
        $result = ["status" => 200];

        try{

            $result['data'] = $staffService->update($request, $id);

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
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staffService = new StaffService();
        $result = ["status" => 200];

        try{

            $result['data'] = $staffService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function ExportStaff(Request $request){
        return (new ExportStaff($request))->download('staffs.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function getDeletedRecords(Request $request){

        $staffService = new StaffService();
        $allSessions = session()->all();

        if ($request->ajax()) {
            $deletedStaffs = $staffService->getDeletedRecords($allSessions);

            return Datatables::of($deletedStaffs)
                    ->addIndexColumn()
                    ->editColumn('show', function ($Staff) {
                        return  ($Staff->working_hours == 'PART_TIME')?"Part Time":"Full Time";
                    })
                    ->addColumn('action', function($row){

                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-xs restore"><i class="material-icons">delete</i> Restore</button>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Staff/viewDeletedStaff')->with("page", "staff");
    }

    public function restore($id)
    {
        $staffService = new StaffService();
        $result = ["status" => 200];
        try{

            $result['data'] = $staffService->restore($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Write code on Method
     *
     * @return response()
    */

    public function restoreAll()
    {
        $staffService = new StaffService();
        $allSessions = session()->all();

        $result = ["status" => 200];
        try{

            $result['data'] = $staffService->restoreAll($allSessions);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function exportStaffSample(){
        return (new ExportStaffSample())->download('sampleStaff.xlsx');
    }
}
?>
