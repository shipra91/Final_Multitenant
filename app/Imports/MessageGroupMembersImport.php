<?php

namespace App\Imports;

use App\Repositories\MessageGroupNameRepository;
use App\Repositories\MessageGroupMembersRepository;

use App\Models\MessageGroupMembers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Throwable;
use Session;
use Carbon\Carbon;

class MessageGroupMembersImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    use Importable;
    public function model(array $row)
    {
        $allSessions = session()->all();
        $row['group_name_id'] = '';
        $messageGroupNameRepository = new MessageGroupNameRepository();
        $messageGroupMembersRepository = new MessageGroupMembersRepository();
        $messageGroupNameDetails = $messageGroupNameRepository->getGroupNameId($row['group_name']);
        if($messageGroupNameDetails){
            $row['group_name_id'] = $messageGroupNameDetails->id;
        }

        if($row['name'] != '' && $row['phone_number'] != ''){

            $check = MessageGroupMembers::where('id_institute', $allSessions['institutionId'])
            ->where('id_academic', $allSessions['academicYear'])
            ->where('id_message_group', $row['group_name_id'])
            ->where('phone_number', $row['phone_number'])
            ->first();
            if(!$check){
                $groupMemberDetails = array(
                    "id_institute" => $allSessions['institutionId'],
                    "id_academic" => $allSessions['academicYear'],
                    "id_message_group" => $row['group_name_id'],
                    "name" => $row['name'],
                    "phone_number" => $row['phone_number'],
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );
                $store = $messageGroupMembersRepository->store($groupMemberDetails);
            }
        }
    }
}
