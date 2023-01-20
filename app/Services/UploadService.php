<?php 
    namespace App\Services;

    use App\Repositories\OrganizationRepository;
    use App\Repositories\InstitutionRepository;
    use League\Flysystem\Filesystem;
    use Storage;
    use Session;
    use Image;

    class UploadService {
      
        public function globalPath(){

            $allSessions = session()->all();
            $idInstitution = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $organizationId = $allSessions['organizationId'];
            
            $institutionRepository = new InstitutionRepository();
            $organizationRepository = new OrganizationRepository();            

            $basePath = 'egenius_multitenant-s3/'.$organizationId.'/'.$idInstitution.'/'.$academicYear.'/';

            return $basePath;

        }

        public function resizeUpload($file, $path){

            $basePath = $this->globalPath();
            $image      = $file;
            $fileName   = md5(time()) . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image);
            $img->resize(null , 200 , function($constraint){
                $constraint->aspectRatio();
            });

            $resource = $img->stream()->detach();
            $response = Storage::disk('s3')->put($basePath.$path.$fileName, $resource);
            $filePath = Storage::disk('s3')->url($basePath.$path.$fileName);
            return $filePath;
        }

        public function fileUpload($file, $path){

            $basePath = $this->globalPath();

            $response = Storage::disk('s3')->put($basePath.$path, $file);
            $filePath = Storage::disk('s3')->url($response);
            return $filePath;
        }

    }

?>