<?php
    namespace App\Services;
    use App\Models\VisitorManagement;
    use App\Repositories\VisitorManagementRepository;
    use Carbon\Carbon;
    use Session;

    class VisitorReportService {

        // Get visitor reports
        public function getReportData($request){
            $visitorManagementRepository = new VisitorManagementRepository();
            return $visitorManagementRepository->visitorReportData($request);
        }
    }
?>
