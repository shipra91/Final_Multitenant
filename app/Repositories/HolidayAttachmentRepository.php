<?php
    namespace App\Repositories;

    use App\Models\HolidayAttachment;
    use App\Interfaces\HolidayAttachmentRepositoryInterface;

    class HolidayAttachmentRepository implements HolidayAttachmentRepositoryInterface{

        public function all(){
            return HolidayAttachment::all();
        }

        public function store($data){
            return HolidayAttachment::create($data);
        }

        public function fetch($idHoliday){
            return HolidayAttachment::where('id_holiday', $idHoliday)->get();
        }

        public function update($data){
            return $data->save();
        }

        // public function delete($idHoliday){
        //     return HolidayAttachment::where('id_holiday', $idHoliday)->delete();
        // }

        public function delete($id){
            return $data = HolidayAttachment::find($id)->delete();
        }

        public function restore($idHoliday){
            return HolidayAttachment::withTrashed()->where('id_holiday', $idHoliday)->restore();
        }
    }
?>