<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use App\Services\GradeService;
use DataTables;
use Session;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $gradeService = new GradeService();
        $allSessions = session()->all();
        
        if ($request->ajax()){
            $data = $gradeService->getAll($allSessions);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if($row['eligibleForEditDelete'] == 'YES'){

                            if(Helper::checkAccess('grade', 'edit')){
                                $btn .= '<a href="/grade/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                            }
                            if(Helper::checkAccess('grade', 'delete')){
                                $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                            }

                        }else{
                            $btn .='No action';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Grade/index')->with("page", "grade");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Grade/addGrade')->with("page", "grade");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gradeService = new GradeService();

        $result = ["status" => 200];

        try{

            $result['data'] = $gradeService->add($request);

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
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gradeService = new GradeService();
        $allSessions = session()->all();

        $selectedData = $gradeService->getGradeSelectedData($id);
        //dd($selectedData);
        return view('Grade/editGrade', ['selectedData' => $selectedData])->with("page", "grade");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gradeService = new GradeService();

        $result = ["status" => 200];

        try{

            $result['data'] = $gradeService->update($request, $id);

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
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gradeService = new GradeService();

        $result = ["status" => 200];

        try{

            $result['data'] = $gradeService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Deleted grade records
    public function getDeletedRecords(Request $request)
    {
        $gradeService = new GradeService();
        $allSessions = session()->all();
        //dd($gradeService->getDeletedRecords());

        if ($request->ajax()){
            $deletedData = $gradeService->getDeletedRecords($allSessions);
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn ='';
                        if(Helper::checkAccess('grade', 'create')){
                            $btn .= '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        }else{
                            $btn .= 'No Access';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Grade/view_deleted_record')->with("page", "grade");
    }

    // Restore grade records
    public function restore($id)
    {
        $gradeService = new GradeService();

        $result = ["status" => 200];

        try{

            $result['data'] = $gradeService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
