<?php

namespace App\Http\Controllers;

use App\Models\FeeHeading;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFeeHeadingRequest;
use App\Services\FeeHeadingService;
use App\Repositories\FeeCategoryRepository;
use DataTables;

class FeeHeadingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $feeHeadingService = new FeeHeadingService();

        if ($request->ajax()){
            $feeHeading = $feeHeadingService->getAll();
            return Datatables::of($feeHeading)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/fee-heading/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        // <a href="javascript:void(0);" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Configurations/FeeHeading')->with("page", "fee_heading");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $feeCategoryRepository = new FeeCategoryRepository();
        $feeCategory = $feeCategoryRepository->all();

        return view('Configurations/addFeeHeading',['fee_category' => $feeCategory])->with("page", "fee_heading");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreFeeHeadingRequest $request)
    {
        $feeHeadingService = new FeeHeadingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeHeadingService->add($request);

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
     * @param  \App\Models\FeeHeading  $feeHeading
     * @return \Illuminate\Http\Response
     */
    public function show(FeeHeading $feeHeading)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeeHeading  $feeHeading
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $feeHeadingService = new FeeHeadingService();
        $feeHeading = $feeHeadingService->find($id);
        // dd($feeHeading);
        return view('Configurations/editFeeHeading', ["feeHeading" => $feeHeading])->with("page", "fee_heading");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeeHeading  $feeHeading
     * @return \Illuminate\Http\Response
     */

    public function update(StoreFeeHeadingRequest $request, $id)
    {
        $feeHeadingService = new FeeHeadingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeHeadingService->update($request, $id);

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
     * @param  \App\Models\FeeHeading  $feeHeading
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $feeHeadingService = new FeeHeadingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeHeadingService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function fetchCategoryWiseHeading(Request $request){

        $feeHeadingService = new FeeHeadingService();
        $idFeeCategory = $request['id'];

        return $feeHeadingService->fetchCategoryWiseHeading($idFeeCategory);
    }
}
