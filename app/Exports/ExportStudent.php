<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExportStudent implements FromQuery, WithHeadings
{

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Query
    */
    public function query()
    {
        DB::enableQueryLog();
        $join = '';
        $array = array_flip($this->request->student_excl);
        $excelColumns = $this->request->student_excl;
        // dd($excelColumns);

        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];
        $academicYear = $allSessions['academicYear'];

        $columnSet = array();
        $orderByColumn = '';

        foreach($excelColumns as $column){

            if($column == 'gender'){
                array_push($columnSet, 'tbl_gender.name as gender');
            }else if($column == 'name'){
                array_push($columnSet, 'tbl_student.name as student_name');
            }else if($column == 'blood_group'){
                array_push($columnSet, 'tbl_blood_group.name as blood_group');
            }else if($column == 'nationality'){
                array_push($columnSet, 'tbl_nationality.name as nationality');
            }else if($column == 'religion'){
                array_push($columnSet, 'tbl_religion.name as religion');
            }else if($column == 'caste_category'){
                array_push($columnSet, 'tbl_categories.name as caste_category');
            }else{
                array_push($columnSet, 'tbl_student.'.$column.'');
            }
        }

        if($this->request->orderBy != ''){

            if($this->request->orderBy == 'gender'){
                $orderByColumn = 'tbl_student.id_gender';
            }else if($this->request->orderBy == 'name'){
                $orderByColumn = 'tbl_student.name';
            }else if($this->request->orderBy == 'blood_group'){
                $orderByColumn = 'tbl_student.id_blood_group';
            }else if($this->request->orderBy == 'nationality'){
                $orderByColumn = 'tbl_student.id_nationality';
            }else if($this->request->orderBy == 'religion'){
                $orderByColumn = 'tbl_student.id_religion';
            }else if($this->request->orderBy == 'caste_category'){
                $orderByColumn = 'tbl_student.id_caste_category';
            }else{
                $orderByColumn = 'tbl_student.'.$this->request->orderBy.'';
            }

        }else{
            $orderByColumn = 'tbl_student.name';
        }

        $newColumnSet = implode("','", $columnSet);
        $newColumnSet = "'" .$newColumnSet."'";

        $studentData = Student::select($columnSet)
                        ->join('tbl_student_mapping', 'tbl_student.id', '=', 'tbl_student_mapping.id_student')
                        ->leftJoin('tbl_gender', 'tbl_student.id_gender', '=', 'tbl_gender.id')
                        ->where('tbl_student_mapping.id_institute', $institutionId)
                        ->where('tbl_student_mapping.id_academic_year', $academicYear);

        if($this->request->selectedStandards[0] != ''){

            $stnadardArr = array();

            foreach($this->request->selectedStandards as $standard){
                $stnadardArr = explode(",", $standard);
            }

            $studentData->whereIn('tbl_student_mapping.id_standard', $stnadardArr);
        }

        if($this->request->selectedGender !=''){
            $studentData->where('tbl_student.id_gender', $this->request->selectedGender);
        }

        if($this->request->selectedFeeType !=''){
            $studentData->where('tbl_student_mapping.id_fee_type', $this->request->selectedFeeType);
        }

        $studentData->leftJoin('tbl_blood_group', 'tbl_student.id_blood_group', '=', 'tbl_blood_group.id')
                    ->leftJoin('tbl_nationality', 'tbl_student.id_nationality', '=', 'tbl_nationality.id')
                    ->leftJoin('tbl_religion', 'tbl_student.id_religion', '=', 'tbl_religion.id')
                    ->leftJoin('tbl_categories', 'tbl_student.id_caste_category', '=', 'tbl_categories.id')
                    ->orderBy(''.$orderByColumn.'')->get();


        // $studentData = Student::query();
        // dd(DB::getQueryLog());
        return $studentData;
    }

    public function headings(): array
    {
        $headingsArray = [];

        if(($this->query()->first()) != ""){

            $columnHeadings = array_keys($this->query()->first()->toArray());

            foreach($columnHeadings as $column){

                $heading = str_replace("_"," ",$column);
                $heading = ucwords($heading);

                array_push($headingsArray, $heading);
            }
        }

        return $headingsArray;
        // return $columnHeadings;
    }
}
