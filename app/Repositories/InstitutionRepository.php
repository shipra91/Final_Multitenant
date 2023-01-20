<?php
    namespace App\Repositories;
    use App\Models\Institution;
    use App\Interfaces\InstitutionRepositoryInterface;
    use App\Repositories\OrganizationRepository;
    use League\Flysystem\Filesystem;
    use Storage;
    use Image;
    use DB;

    class InstitutionRepository implements InstitutionRepositoryInterface{

        public function all(){
            return Institution::orderBy('created_at', 'ASC')->get();
        }

        public function store($data){
            return $institution = Institution::create($data);
        }

        public function fetch($id){
            $institution = Institution::find($id);
            return $institution;
        }

        public function getInstitutionId($institutionName){
            return Institution::where('name', $institutionName)->first();

        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $institution = Institution::find($id)->delete();
        }

        public function fetchInstitution($idOrganization){
            return Institution::where('id_organization', $idOrganization)->get();
        }

        public function fetchOrganizationInstitution($idOrganization){
            return Institution::where('id_organization', $idOrganization)->get();
        }

        public function basePath($organizationId, $institutionName){

            $organizationRepository = new OrganizationRepository();

            //oragnization detail
            $getOrganization = $organizationRepository->fetch($organizationId);
            $organizationName = $getOrganization->name;

            $basePath = 'egenius_multitenant-s3/'.$organizationName.'/'.$institutionName.'/attachments/';

            return $basePath;
        }

        // S3 File Upload Function
        public function upload($file, $organizationId, $institutionName ){

            $basePath = $this->basePath($organizationId, $institutionName);
            $image      = $file;
            $fileName   = md5(time()) . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image);
            $img->resize(null , 200 , function($constraint){
                $constraint->aspectRatio();
            });

            $resource = $img->stream()->detach();
            $path = Storage::disk('s3')->put($basePath.$fileName, $resource);
            $filePath = Storage::disk('s3')->url($basePath.$fileName);
            return $filePath;
        }

        // S3 Others File Upload Function
        public function otherFileUpload($file){

            $basePath = $this->basePath();
            $path = Storage::disk('s3')->put($basePath, $file);
            $filePath = Storage::disk('s3')->url($path);
            return $filePath;
        }

        public function allDeleted(){
            return Institution::onlyTrashed()->get();
        }

        public function findDeletedInstitution($id){
            return Institution::withTrashed()->find($id);
        }

        public function restore($id){
            return Institution::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return Institution::onlyTrashed()->restore();
        }
    }
?>
