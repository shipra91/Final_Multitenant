<?php
    namespace App\Services;

    use App\Models\AcademicYear;
    use App\Repositories\AcademicYearRepository;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class AcademicYearService {

        // Get all academic year
        public function getAll(){

            $academicYearRepository = new AcademicYearRepository();
            $academicYears = $academicYearRepository->all();
            return $academicYears;
        }

        // Insert academic year
        public function add($academicYearData){

            $academicYearRepository = new AcademicYearRepository();

            $fromDate = Carbon::createFromFormat('d/m/Y', $academicYearData->fromDate)->format('Y-m-d');
            $toDate = Carbon::createFromFormat('d/m/Y', $academicYearData->toDate)->format('Y-m-d');

            $check = AcademicYear::where('name', $academicYearData->academicYearName)
                                // ->where('from_date', $fromDate)
                                // ->where('to_date', $toDate)
                                ->first();
            if(!$check){

                $data = array(
                    'name' => $academicYearData->academicYearName,
                    'from_date' => $fromDate,
                    'to_date' => $toDate,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $academicYearRepository->store($data);

                if($storeData) {

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

        // Get particular academic year
        public function find($id){

            $academicYearRepository = new AcademicYearRepository();

            $academicYear = $academicYearRepository->fetch($id);
            return $academicYear;
        }

        // Update academic year
        public function update($academicYearData, $id){

            $academicYearRepository = new AcademicYearRepository();

            $fromDate = Carbon::createFromFormat('d/m/Y', $academicYearData->fromDate)->format('Y-m-d');
            $toDate = Carbon::createFromFormat('d/m/Y', $academicYearData->toDate)->format('Y-m-d');

            $check = AcademicYear::where('name', $academicYearData->academicYearName)
                                // ->where('from_date', $fromDate)
                                // ->where('to_date', $toDate)
                                ->where('id', '!=', $id)
                                ->first();
            if(!$check){

                $academicData = $academicYearRepository->fetch($id);

                $academicData->name =$academicYearData->academicYearName;
                $academicData->from_date = $fromDate;
                $academicData->to_date = $toDate;
                $academicData->modified_by = Session::get('userId');
                $academicData->updated_at = Carbon::now();

                $updateData = $academicYearRepository->update($academicData);

                if($updateData) {

                    $signal = 'success';
                    $msg = 'Data updated successfully!';

                }else{

                    $signal = 'failure';
                    $msg = 'Error updated data!';
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

        // Delete academic year
        public function delete($id){

            $academicYearRepository = new AcademicYearRepository();

            $academicYear = $academicYearRepository->delete($id);

            if($academicYear){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>
