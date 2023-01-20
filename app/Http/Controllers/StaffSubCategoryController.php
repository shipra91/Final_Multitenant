<?php

namespace App\Http\Controllers;

use App\Models\StaffSubCategory;
use Illuminate\Http\Request;
use App\Services\StaffSubCategoryService;
use App\Http\Requests\StoreStaffSubCategoryRequest;
use DataTables;

class StaffSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $staffSubCategoryService = new StaffSubCategoryService();

        $staffCategory = $staffSubCategoryService->allStaffCategory();

        if ($request->ajax()){
            $staffSubCategory = $staffSubCategoryService->getAll();
            return Datatables::of($staffSubCategory)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/staff-sub-category/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        // <a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Configurations/staffSubCategory', ['staffCategory' => $staffCategory])->with("page", "staff_sub_category");
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

    public function store(StoreStaffSubCategoryRequest $request)
    {
        $staffSubCategoryService = new StaffSubCategoryService();

        $result = ["status" => 200];

        try{

            $result['data'] = $staffSubCategoryService->add($request);

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
     * @param  \App\Models\StaffSubCategory  $staffSubCategory
     * @return \Illuminate\Http\Response
     */
    public function show(StaffSubCategory $staffSubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaffSubCategory  $staffSubCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staffSubCategoryService = new StaffSubCategoryService();

        $staffCategories = $staffSubCategoryService->allStaffCategory();
        $selectedStaffSubCategory = $staffSubCategoryService->find($id);

        return view('Configurations/editStaffSubCategory', ["selectedStaffSubCategory" => $selectedStaffSubCategory, "staffCategories" => $staffCategories])->with("page", "staff_sub_category");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaffSubCategory  $staffSubCategory
     * @return \Illuminate\Http\Response
     */

    public function update(StoreStaffSubCategoryRequest $request, $id)
    {
        $staffSubCategoryService = new StaffSubCategoryService();

        $result = ["status" => 200];

        try{

            $result['data'] = $staffSubCategoryService->update($request, $id);

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
     * @param  \App\Models\StaffSubCategory  $staffSubCategory
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $staffSubCategoryService = new StaffSubCategoryService();

        $result = ["status" => 200];

        try{

            $result['data'] = $staffSubCategoryService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Get staff subcategory
    public function getSubcategory(Request $request){

        $staffSubCategoryService = new StaffSubCategoryService();
        $result = ["status" => 200];

        try{

            $categoryId = $request->catId;
            $result['data'] = $staffSubCategoryService->getSubcategoryOption($categoryId);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Get all staff subcategory
    public function getAllSubcategory(Request $request){
        $staffSubCategoryService = new StaffSubCategoryService();
        $result = ["status" => 200];

        try{

            $categoryArrayId = $request->catId;
            $result['data'] = $staffSubCategoryService->getAllSubcategory($categoryArrayId);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
