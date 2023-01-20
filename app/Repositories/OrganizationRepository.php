<?php
    namespace App\Repositories;
    use App\Models\Organization;
    use App\Interfaces\OrganizationRepositoryInterface;
    use App\Repositories\InstitutionRepository;
    use Intervention\Image\Facades\Image;
    use League\Flysystem\Filesystem;
    use Storage;
    use Session;
    use DB;

    class OrganizationRepository implements OrganizationRepositoryInterface{

        public function all(){
            return Organization::orderBy('created_at', 'ASC')->get();
        }

        public function store($data){
            return Organization::create($data);
        }

        public function fetch($id){
            return Organization::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $message = Organization::find($id)->delete();
        }

        // public function filePath(){
        //     $allSessions = session()->all();
        //     $idInstitution = $allSessions['institutionId'];
        //     $academicYear = $allSessions['academicYearLabel'];
        //     $organizationId = $allSessions['organizationId'];

        //     //oragnization detail
        //     $getOrganization = $this->fetch($organizationId);
        //     $organizationName = $getOrganization->name;

        //     //institution detail
        //     $getInstitution = $this->institutionRepository->fetch($idInstitution);
        //     $institutionName = $getInstitution->name;

        //     $basePath = 'egenius_multitenant-s3/'.$organizationName.'/attachments';

        //     return $basePath;
        // }

        // File upload function
        public function upload($file, $basePath){

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

        public function uploadOtherFiles($file, $basePath){
            $path = Storage::disk('s3')->put($basePath, $file);
            $filePath = Storage::disk('s3')->url($path);
            return $filePath;
        }

        public function allDeleted(){
            return Organization::onlyTrashed()->get();
        }

        public function restore($id){
            return Organization::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return Organization::onlyTrashed()->restore();
        }
    }
?>
