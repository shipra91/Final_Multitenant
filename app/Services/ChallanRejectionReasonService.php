<?php
 namespace App\Services;

 use App\Models\ChallanRejectionReason;
 use App\Repositories\ChallanRejectionReasonRepository;
 use Session;

class ChallanRejectionReasonService {
    public function add($request) {

    }

    public function getAll() {

        $challanRejectionReasonRepository = new ChallanRejectionReasonRepository();
        $challanRejectionReasons = $challanRejectionReasonRepository->all();
        foreach($challanRejectionReasons as $reason) {
            $rejectionReason[] = $reason->reason;
        }
        return $rejectionReason;
    }

}

?>