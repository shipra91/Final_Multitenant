<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Services\StaffService;
use App\Services\OrganizationService;
use App\Repositories\RoleRepository;
use App\Repositories\StaffCategoryRepository;
use App\Repositories\StaffSubCategoryRepository;
use Illuminate\Http\Request;
use Session;
use DataTables;

class InstitutionUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $staffService = new StaffService();
        $organizationService = new OrganizationService();
        $roleRepository = new RoleRepository();
        $staffCategoryRepository = new StaffCategoryRepository();
        $staffSubCategoryRepository = new StaffSubCategoryRepository();

        $roleId = $categoryId = $subCategoryId = '';

        $input = \Arr::except($request->all(),array('_token', '_method'));

        $staffDetails = $staffService->getStaffData();        
        $organizationData = $organizationService->all();
        $role = $roleRepository->getRoleID('superadmin');
        if($role){
            $roleId = $role->id;
        }
        $staffCategory = $staffCategoryRepository->getCategoryId('TEACHING');
        if($staffCategory){
            $categoryId = $staffCategory->id;

            $staffSubCategory = $staffSubCategoryRepository->getSubCategoryId($staffCategory->id);
            if($staffSubCategory){   
                $subCategoryId = $staffSubCategory->id;
                // dd(Session::get('userId'));
            }           
        }
        // dd(Session::get('userId'));
        if ($request->ajax()){

            $staffData = $staffService->getAllSuperAdmin(Session::get('userId'));
            // dd($staffData);
            return Datatables::of($staffData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';

                        // if($row['editElligibility'] === 'YES'){
                        //     $btn .='<a href="/etpl/staff/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                        //     <a href="javascript:void(0);" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        // }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('/etpl/createUser', ['staffDetails' => $staffDetails, 'organizationData' => $organizationData, 'roleId' => $roleId, 'categoryId' => $categoryId, 'subCategoryId' => $subCategoryId]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoginOtp  $loginOtp
     * @return \Illuminate\Http\Response
     */
    public function show(LoginOtp $loginOtp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoginOtp  $loginOtp
     * @return \Illuminate\Http\Response
     */
    public function edit(LoginOtp $loginOtp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoginOtp  $loginOtp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoginOtp $loginOtp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoginOtp  $loginOtp
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoginOtp $loginOtp)
    {
        //
    }
}
