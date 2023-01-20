<?php

namespace App\Http\Controllers;

use App\Models\StandardYear;
use Illuminate\Http\Request;
use App\Services\StandardYearService;
use App\Http\Requests\StoreStandardYearRequest;
use DataTables;

class StandardYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $standardYearService = new StandardYearService();

        if ($request->ajax()){
            $standardYearDetails = $standardYearService->getStandardYearData();
            return Datatables::of($standardYearDetails)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/standard-year/'.$row->id.'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        // <a href="javascript:void();" type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Configurations/standardYearCreation')->with("page", "standard_year");
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

    public function store(StoreStandardYearRequest $request)
    {
        $standardYearService = new StandardYearService();

        $result = ["status" => 200];

        try{

            $result['data'] = $standardYearService->add($request);

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
     * @param  \App\Models\StandardYear  $standardYear
     * @return \Illuminate\Http\Response
     */
    public function show(StandardYear $standardYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StandardYear  $standardYear
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $standardYearService = new StandardYearService();
        $standardYear = $standardYearService->find($id);

        return view('Configurations/editStandardYear', ["standardYear" => $standardYear])->with("page", "standard_year");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StandardYear  $standardYear
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {

        $standardYearService = new StandardYearService();

        $result = ["status" => 200];

        try{

            $result['data'] = $standardYearService->update($request, $id);

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
     * @param  \App\Models\StandardYear  $standardYear
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $standardYearService = new StandardYearService();

        $result = ["status" => 200];

        try{

            $result['data'] = $standardYearService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
