<?php

namespace App\Http\Controllers;

use App\Models\FeeCategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFeeCategoryRequest;
use App\Services\FeeCategoryService;
use DataTables;

class FeeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $feeCategoryService = new FeeCategoryService();

        if ($request->ajax()){
            $feeCategory = $feeCategoryService->getAll();
            return Datatables::of($feeCategory)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/fee-category/'.$row->id.'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        // <a href="javascript:void(0);" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Configurations/feeCategory')->with("page", "fee_category");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Configurations/addFeeCategory');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreFeeCategoryRequest $request)
    {
        $feeCategoryService = new FeeCategoryService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeCategoryService->add($request);

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
     * @param  \App\Models\FeeCategory  $feeCategory
     * @return \Illuminate\Http\Response
     */
    public function show(FeeCategory $feeCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeeCategory  $feeCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $feeCategoryService = new FeeCategoryService();

        $feeCategory = $feeCategoryService->find($id);
        return view('Configurations/editFeeCategory', ["feeCategory" => $feeCategory])->with("page", "fee_category");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeeCategory  $feeCategory
     * @return \Illuminate\Http\Response
     */

    public function update(StoreFeeCategoryRequest $request, $id)
    {
        $feeCategoryService = new FeeCategoryService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeCategoryService->update($request, $id);

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
     * @param  \App\Models\FeeCategory  $feeCategory
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $feeCategoryService = new FeeCategoryService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeCategoryService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
