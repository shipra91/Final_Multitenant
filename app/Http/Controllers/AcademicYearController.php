<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Services\AcademicYearService;
use App\Http\Requests\StoreAcademicYearRequest;
use DataTables;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $academicYearService = new AcademicYearService();

        if ($request->ajax()){
            $academicYear = $academicYearService->getAll();
            return Datatables::of($academicYear)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/academic-year/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                        <a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('AcademicYear/index')->with("page", "academic_year");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAcademicYearRequest $request)
    {
        $academicYearService = new AcademicYearService();

        $result = ["status" => 200];

        try{

            $result['data'] = $academicYearService->add($request);

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
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicYear $academicYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $academicYearService = new AcademicYearService();

        $academicYear = $academicYearService->getAll();
        $selectedacademicYear = $academicYearService->find($id);

        return view('AcademicYear/editAcademicYear', ["selectedacademicYear" => $selectedacademicYear, "academicYear" => $academicYear])->with("page", "academic_year");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAcademicYearRequest $request, $id)
    {
        $academicYearService = new AcademicYearService();

        $result = ["status" => 200];

        try{

            $result['data'] = $academicYearService->update($request, $id);

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
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $academicYearService = new AcademicYearService();

        $result = ["status" => 200];

        try{

            $result['data'] = $academicYearService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
