<?php

namespace App\Http\Controllers;

use App\Models\FeeType;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFeeTypeRequest;
use App\Services\FeeTypeService;
use DataTables;

class FeeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $feeTypeService = new FeeTypeService();

        if ($request->ajax()){
            $feeTypes = $feeTypeService->getAll();
            return Datatables::of($feeTypes)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/fee-type/'.$row->id.'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        // <a href="javascript:void(0);" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Configurations/feeTypeCreation')->with("page", "fee_type");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Configurations/addFeeType')->with("page", "fee_type");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreFeeTypeRequest $request)
    {
        $feeTypeService = new FeeTypeService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeTypeService->add($request);

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
     * @param  \App\Models\FeeType  $feeType
     * @return \Illuminate\Http\Response
     */
    public function show(FeeType $feeType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeeType  $feeType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $feeTypeService = new FeeTypeService();

        $feeType = $feeTypeService->find($id);
        return view('Configurations/editFeeType', ["feeType" => $feeType])->with("page", "fee_type");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeeType  $feeType
     * @return \Illuminate\Http\Response
     */

    public function update(StoreFeeTypeRequest $request, $id)
    {
        $feeTypeService = new FeeTypeService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeTypeService->update($request, $id);

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
     * @param  \App\Models\FeeType  $feeType
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $feeTypeService = new FeeTypeService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeTypeService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
