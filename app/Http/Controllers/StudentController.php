<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Services\CustomFieldService;
use App\Http\Requests\StoreStudentRequest;
use App\Interfaces\StudentMappingRepositoryInterface;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportStudent;
use App\Exports\ExportStudentSample;
use App\Imports\StudentImport;
use DataTables;
use Helper;

class StudentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        $studentService = new StudentService();
        $allSessions = session()->all();

        $fieldDetails = $studentService->getFieldDetails($allSessions);

        $input = \Arr::except($request->all(),array('_token', '_method'));
        $allColumns = $studentService->getTableColumns();

        if ($request->ajax()) {

            $studentData = $studentService->fetchStudents($input, $allSessions);

            return Datatables::of($studentData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('student', 'edit')){
                            $btn .= '<a href="/student/'.$row['id_student'].'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('student', 'view')){
                            $btn .= '<a href="/student-detail/'.$row['id_student'].'" type="button" rel="tooltip" title="View"  class="text-info"><i class="material-icons">account_box</i></a>';
                        }
                        if(Helper::checkAccess('student', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id_student'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Student/index', ['fieldDetails' => $fieldDetails, 'allColumns' => $allColumns])->with("page", "student");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customFieldService = new CustomFieldService();
        $studentService = new StudentService();
        $allSessions = session()->all();

        $institutionId = $allSessions['institutionId'];
        $fieldDetails = $studentService->getFieldDetails($allSessions);
        $customFields = $customFieldService->fetchRequiredCustomFields($institutionId, 'student');
        return view('Student/studentCreation',["customFields" => $customFields, "fieldDetails" => $fieldDetails])->with("page", "student");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request){
      
        $studentService = new StudentService();
        $result = ["status" => 200];

        try{

            $result['data'] = $studentService->add($request);

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
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $studentService = new StudentService();
        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];

        $fieldDetails = $studentService->getFieldDetails($allSessions);
        $customFieldDetails = $studentService->fetchCustomFieldValues($id);
        $customFileDetails = $studentService->fetchCustomFileValues($id);
        $studentDetails = $studentService->find($id);

        return view('Student/viewStudent',["studentDetails" => $studentDetails, "fieldDetails" => $fieldDetails, "customFieldDetails" => $customFieldDetails, "customFileDetails" => $customFileDetails])->with("page", "student");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customFieldService = new CustomFieldService();
        $studentService = new StudentService();
        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];

        $studentDetails = $studentService->find($id);
        // dd($studentDetails['standard_subjects']);
        $fieldDetails = $studentService->getFieldDetails($allSessions);
        $customFields = $customFieldService->getCustomFieldsEdit($institutionId, 'student', 'id_student', $id, 'App\Models\StudentCustom');
        
        return view('Student/editStudent', ["data" => $studentDetails, "customFields" => $customFields, "fieldDetails" => $fieldDetails])->with("page", "student");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $studentService = new StudentService();
        $result = ["status" => 200];

        try{

            $result['data'] = $studentService->update($request, $id);

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
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $studentService = new StudentService();
        $result = ["status" => 200];

        try{

            $result['data'] = $studentService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Export student details
    public function ExportStudent(Request $request){
        // dd(new ExportStudent($request));
        // return (new ExportStudent($request))->download('students.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        return Excel::download(new ExportStudent($request), 'student.xlsx');
    }

    public function getDeletedRecords(Request $request){

        $studentService = new StudentService();
        $allSessions = session()->all();

        if ($request->ajax()) {
            $deletedStudents = $studentService->getDeletedRecords($allSessions); 
            
            return Datatables::of($deletedStudents)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){                        
                        $btn ='';
                        if(Helper::checkAccess('student', 'create')){
                            $btn .= '<button type="button" data-id="'.$row->id.'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        }else{
                            $btn .= 'No Access';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Student/viewDeletedStudent')->with("page", "student");
    }

    // Restore student records
    public function restore($id)
    {
        $result = ["status" => 200];

        try{

            $result['data'] = $this->studentService->restore($id);

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
        $studentService = new StudentService();
        $allSessions = session()->all();
        $result = ["status" => 200];
        try{
            
            $result['data'] = $studentService->restoreAll($allSessions);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

    public function getStudents(Request $request)
    {
        $studentService = new StudentService();
        $allSessions = session()->all();

        $studentDetails = $studentService->fetchStudentDetails($request, $allSessions);
        // dd($subjectDetails);
        return $studentDetails;
    }

    public function getStandardStudents(Request $request)
    {
        $studentService = new StudentService();
        $allSessions = session()->all();
        
        $standardId = $request['standardId'];
        $studentDetails = $studentService->fetchStandardStudents($standardId, $allSessions);
        return $studentDetails;
    }

    public function exportStudentSample(){
        return (new ExportStudentSample())->download('sampleStudent.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function storeImportData(Request $request){

        $file = $request->file('file');
        Excel::import(new StudentImport, $file);
        return back()->withStatus('Excel file imported successfully');

    }
}
