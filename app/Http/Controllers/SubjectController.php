<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Services\SubjectService;
use App\Services\SubjectTypeService;
use App\Http\Requests\StoreSubjectRequest;
use DataTables;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $subjectService = new SubjectService();
        $subjectTypeService = new SubjectTypeService();

        if ($request->ajax()){
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : 10;

            $allSubjects = $subjectService->getAll($limit, $page);

            return Datatables::of($allSubjects)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/subject/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        // <a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $subjectTypes = $subjectTypeService->getAll();
        return view('Configurations/subject', ['subjectTypes' => $subjectTypes])->with("page", "subject");
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

    public function store(StoreSubjectRequest $request)
    {
        $subjectService = new SubjectService();

        $result = ["status" => 200];

        try{

            $result['data'] = $subjectService->add($request);

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
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $subjectService = new SubjectService();
        $subjectTypeService = new SubjectTypeService();

        $subject = $subjectService->find($id);
        $subjectTypes = $subjectTypeService->getAll();
        return view('Configurations/editSubject', ['subject' => $subject, 'subjectTypes' => $subjectTypes])->with("page", "subject");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */

    public function update(StoreSubjectRequest $request, $id)
    {
        $subjectService = new SubjectService();

        $result = ["status" => 200];

        try{

            $result['data'] = $subjectService->update($request, $id);

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
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $subjectService = new SubjectService();

        $result = ["status" => 200];

        try{

            $result['data'] = $subjectService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getSubjectDetails(Request $request)
    {
        $subjectService = new SubjectService();

        $subjectId = $request['id'];
        return $subjectService->find($subjectId);
    }
}
