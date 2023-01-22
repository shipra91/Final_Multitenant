<?php

namespace App\Http\Controllers;

use App\Models\SubjectPart;
use App\Services\SubjectPartService;
use Illuminate\Http\Request;
use DataTables;
use Helper;

class SubjectPartCreationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subjectPartService = new SubjectPartService();
        $allSessions = session()->all();

        if ($request->ajax()){

            $allParts = $subjectPartService->getAll($allSessions);
            // dd($allParts);
            return Datatables::of($allParts)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';

                        if(Helper::checkAccess('subject-part', 'edit')){
                            $btn = '<a href="/subject-part/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('subject-part', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $options = ['MARK', 'GRADE', 'BOTH'];
        return view('Exam/subjectPartCreation', ['options' => $options])->with('page', 'subject_part');
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
    public function store(Request $request)
    {
        $subjectPartService = new SubjectPartService();

        $result = ["status" => 200];

        try{

            $result['data'] = $subjectPartService->add($request);

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
     * @param  \App\Models\SubjectPartCreation  $subjectPartCreation
     * @return \Illuminate\Http\Response
     */
    public function show(SubjectPartCreation $subjectPartCreation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubjectPartCreation  $subjectPartCreation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subjectPartService = new SubjectPartService();
        $fetchData = $subjectPartService->fetchData($id);

        $options = ['MARK', 'GRADE', 'BOTH'];

        return view('Exam/subjectPartEdit', ['options' => $options, 'fetchData' => $fetchData])->with('page', 'subject_part');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubjectPartCreation  $subjectPartCreation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subjectPartService = new SubjectPartService();

        $result = ["status" => 200];

        try{

            $result['data'] = $subjectPartService->update($request, $id);

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
     * @param  \App\Models\SubjectPartCreation  $subjectPartCreation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subjectPartService = new SubjectPartService();

        $result = ["status" => 200];

        try{

            $result['data'] = $subjectPartService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
