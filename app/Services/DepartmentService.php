<?php
    namespace App\Services;
    use App\Models\Department;
    use App\Services\DepartmentService;
    use App\Repositories\DepartmentRepository;
    use Carbon\Carbon;
    use Session;

    class DepartmentService {

        // Get all department
        public function getAll(){

            $departmentRepository = new DepartmentRepository();
            $department = $departmentRepository->all();

            return $department;
        }

        // Get particular department
        public function find($id){

            $departmentRepository = new DepartmentRepository();
            $department = $departmentRepository->fetch($id);

            return $department;
        }

        // Insert department
        public function add($departmentData){

            $departmentRepository = new DepartmentRepository();

            $check = Department::where('name', $departmentData->department)->first();

            if(!$check){

                $data = array(
                    'name' => $departmentData->department,
                    'created_by' => Session::get('userId'),
                    'modified_by' => ''
                );

                $storeData = $departmentRepository->store($data);

                if($storeData){
                    $signal = 'success';
                    $msg = 'Data inserted successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error inserting data!';
                }

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Update department
        public function update($departmentData, $id){

            $departmentRepository = new DepartmentRepository();

            $check = Department::where('name', $departmentData->department)
                                ->where('id', '!=', $id)->first();

            if(!$check){

                $departmentDetails = $departmentRepository->fetch($id);

                $departmentDetails->name = $departmentData->department;
                $departmentDetails->modified_by = Session::get('userId');
                $departmentDetails->updated_at = Carbon::now();

                $updateData = $departmentRepository->update($departmentDetails);

                if($updateData){
                    $signal = 'success';
                    $msg = 'Data updated successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error updating data!';
                }

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Delete department
        public function delete($id){

            $departmentRepository = new DepartmentRepository();

            $department = $departmentRepository->delete($id);

            if($department){

                $signal = 'success';
                $msg = 'Department deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
