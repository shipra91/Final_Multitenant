<?php

namespace App\Http\Controllers;

use App\Models\Standard;
use Illuminate\Http\Request;
use App\Services\StandardService;
use App\Http\Requests\StoreStandardRequest;
use DataTables;

class StandardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $standardService = new StandardService();

        if ($request->ajax()){
            $standards = $standardService->getAll();
            return Datatables::of($standards)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/standard/'.$row->id.'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        // <a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Configurations/standardCreation')->with("page", "standard");
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

    public function store(StoreStandardRequest $request)
    {
        $standardService = new StandardService();

        $result = ["status" => 200];

        try{

            $result['data'] = $standardService->add($request);

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
     * @param  \App\Models\Standard  $standard
     * @return \Illuminate\Http\Response
     */

    public function show(Standard $standard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Standard  $standard
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $standardService = new StandardService();
        $standard = $standardService->find($id);

        return view('Configurations/editStandard', ["standard" => $standard])->with("page", "standard");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Standard  $standard
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $standardService = new StandardService();

        $result = ["status" => 200];

        try{

            $result['data'] = $standardService->update($request, $id);

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
     * @param  \App\Models\Standard  $standard
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $standardService = new StandardService();

        $result = ["status" => 200];

        try{

            $result['data'] = $standardService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
