<?php

namespace App\Exports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Repositories\RoleRepository;
use DB;
use Session;


class ExportStaff implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($request)
    {
        $this->request = $request;
    }

    // public function query()
    // {
    //     DB::enableQueryLog();   
    //     $columns = implode("','", $this->request->staff_excl);
    //     $columns = "'" .$columns."'";

    //     $excelColumns = $this->request->staff_excl;
    //     array_push($excelColumns, 'tbl_gender.name as gender');

    //     if($this->request->selectedCategory !=''){
    //         $staffData = Staff::query()->where('id_staff_category', $this->request->selectedCategory)->select($this->request->staff_excl)->join('tbl_gender', 'tbl_staff.id_gender', '=', 'tbl_gender.id');
    //     }else{
    //         $staffData = Staff::query()->select('tbl_staff.name as staff_name', 'tbl_gender.name as gender')->join('tbl_gender', 'tbl_staff.id_gender', '=', 'tbl_gender.id');
    //     }
    //     // dd(DB::getQueryLog());
        
    //     return $staffData;
    // }

    public function query()
    {
        DB::enableQueryLog(); 

        $roleRepository = new RoleRepository();
        $allSessions = session()->all();
        $idInstitution = $allSessions['institutionId'];
        $idAcademic = $allSessions['academicYear'];

        $roleData = $roleRepository->getRoleID('superadmin');

        $join = '';
        $array = array_flip($this->request->staff_excl);
        $excelColumns = $this->request->staff_excl;
        // dd($excelColumns);

        $columnSet = array();
        $orderByColumn = '';

        foreach($excelColumns as $column){

            if($column == 'gender'){
                array_push($columnSet, 'tbl_gender.name as gender');
            }else if($column == 'name'){
                array_push($columnSet, 'tbl_staff.name as staff_name');
            }else if($column == 'blood_group'){
                array_push($columnSet, 'tbl_blood_group.name as blood_group');
            }else if($column == 'designation'){
                array_push($columnSet, 'tbl_designations.name as designation');
            }else if($column == 'department'){
                array_push($columnSet, 'tbl_department.name as department');
            }else if($column == 'role'){
                array_push($columnSet, 'tbl_role.display_name as role');
            }else if($column == 'staff_category'){
                array_push($columnSet, 'tbl_staff_categories.name as staff_category');
            }else if($column == 'staff_subcategory'){
                array_push($columnSet, 'tbl_staff_sub_categories.name as staff_subcategory');
            }else if($column == 'nationality'){
                array_push($columnSet, 'tbl_nationality.name as nationality');
            }else if($column == 'religion'){
                array_push($columnSet, 'tbl_religion.name as religion');
            }else if($column == 'caste_category'){
                array_push($columnSet, 'tbl_categories.name as caste_category');
            }else{
                array_push($columnSet, 'tbl_staff.'.$column.'');
            } 
        }    
        
        if($this->request->orderBy != ''){
            if($this->request->orderBy == 'gender'){
                $orderByColumn = 'tbl_staff.id_gender';
            }else if($this->request->orderBy == 'name'){
                $orderByColumn = 'tbl_staff.name';
            }else if($this->request->orderBy == 'blood_group'){
                $orderByColumn = 'tbl_staff.id_blood_group';
            }else if($this->request->orderBy == 'designation'){
                $orderByColumn = 'tbl_staff.id_designation';
            }else if($this->request->orderBy == 'department'){
                $orderByColumn = 'tbl_staff.id_department';
            }else if($this->request->orderBy == 'role'){
                $orderByColumn = 'tbl_staff.id_role';
            }else if($this->request->orderBy == 'staff_category'){
                $orderByColumn = 'tbl_staff.id_staff_category';
            }else if($this->request->orderBy == 'staff_subcategory'){
                $orderByColumn = 'tbl_staff.id_staff_subcategory';
            }else if($this->request->orderBy == 'nationality'){
                $orderByColumn = 'tbl_staff.id_nationality';
            }else if($this->request->orderBy == 'religion'){
                $orderByColumn = 'tbl_staff.id_religion';
            }else if($this->request->orderBy == 'caste_category'){
                $orderByColumn = 'tbl_staff.id_caste_category';
            }else{
                $orderByColumn = 'tbl_staff.'.$this->request->orderBy.'';
            }        
        }else{
            $orderByColumn = 'tbl_staff.name';
        } 
        
        $newColumnSet = implode("','", $columnSet);
        $newColumnSet = "'" .$newColumnSet."'";
        $condition = '';


        if($this->request->selectedCategory !=''){
            $staffData = Staff::query()
                        ->where('id_institute', $idInstitution)                        
                        ->whereNot('id_role', $roleData->id)
                        ->where('id_staff_category', $this->request->selectedCategory)->select($columnSet)
                        ->join('tbl_gender', 'tbl_staff.id_gender', '=', 'tbl_gender.id')
                        ->leftJoin('tbl_blood_group', 'tbl_staff.id_blood_group', '=', 'tbl_blood_group.id')
                        ->leftJoin('tbl_designations', 'tbl_staff.id_designation', '=', 'tbl_designations.id')
                        ->leftJoin('tbl_department', 'tbl_staff.id_department', '=', 'tbl_department.id')
                        ->join('tbl_role', 'tbl_staff.id_role', '=', 'tbl_role.id')
                        ->leftJoin('tbl_staff_categories', 'tbl_staff.id_staff_category', '=', 'tbl_staff_categories.id')
                        ->leftJoin('tbl_staff_sub_categories', 'tbl_staff.id_staff_subcategory', '=', 'tbl_staff_sub_categories.id')
                        ->leftJoin('tbl_nationality', 'tbl_staff.id_nationality', '=', 'tbl_nationality.id')
                        ->leftJoin('tbl_religion', 'tbl_staff.id_religion', '=', 'tbl_religion.id')
                        ->leftJoin('tbl_categories', 'tbl_staff.id_caste_category', '=', 'tbl_categories.id')
                        ->whereNull('tbl_staff.deleted_at')
                        ->orderBy(''.$orderByColumn.'');
        }else{
            $staffData = Staff::query()->select($columnSet)
                        ->join('tbl_gender', 'tbl_staff.id_gender', '=', 'tbl_gender.id')
                        ->leftJoin('tbl_blood_group', 'tbl_staff.id_blood_group', '=', 'tbl_blood_group.id')
                        ->leftJoin('tbl_designations', 'tbl_staff.id_designation', '=', 'tbl_designations.id')
                        ->leftJoin('tbl_department', 'tbl_staff.id_department', '=', 'tbl_department.id')
                        ->join('tbl_role', 'tbl_staff.id_role', '=', 'tbl_role.id')
                        ->leftJoin('tbl_staff_categories', 'tbl_staff.id_staff_category', '=', 'tbl_staff_categories.id')
                        ->leftJoin('tbl_staff_sub_categories', 'tbl_staff.id_staff_subcategory', '=', 'tbl_staff_sub_categories.id')
                        ->leftJoin('tbl_nationality', 'tbl_staff.id_nationality', '=', 'tbl_nationality.id')
                        ->leftJoin('tbl_religion', 'tbl_staff.id_religion', '=', 'tbl_religion.id')
                        ->leftJoin('tbl_categories', 'tbl_staff.id_caste_category', '=', 'tbl_categories.id')                        
                        ->where('id_institute', $idInstitution)
                        ->whereNot('id_role', $roleData->id)
                        ->whereNull('tbl_staff.deleted_at')
                        ->orderBy(''.$orderByColumn.'');
        }
        return $staffData;
    }

    public function headings(): array
    {
        $headingsArray = [];
        $columnHeadings = array_keys($this->query()->first()->toArray());
        // foreach($columnHeadings as $column){

        //     $heading = str_replace("_"," ",$column);
        //     $heading = ucwords($heading);

        //     array_push($headingsArray, $heading);
        // }

        // return $headingsArray;

        return $columnHeadings;
    }
}



