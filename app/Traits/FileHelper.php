<?php

namespace App\Traits;

use Aws\S3\S3Client;
use Illuminate\Http\UploadedFile;

trait FileHelper
{
    private function initClient()
    {
        if(! app()->environment('local')){
            return new S3Client([
                'region' => config('filesystems.disks.s3.region'),
                'version' => 'latest'
            ]);
        }
        else {
            $parameters = [
                'credentials' => [
                    'key' => config('filesystems.disks.s3.key'),
                    'secret' => config('filesystems.disks.s3.secret'),
//                    'token' => config('filesystems.disks.s3.token')
                ],
                'region' => config('filesystems.disks.s3.region'),
                'version' => 'latest'
            ];

            if(! empty(config('filesystems.disks.s3.url'))){
                $parameters['url'] = config('filesystems.disks.s3.url');
            }

            return new S3Client($parameters);
        }
    }

    public function uploadToS3(UploadedFile $uploadedFile, $name, $contentType = "")
    {
        if($uploadedFile){
            $filePath = $uploadedFile->getRealPath();
            $key = "{$name}.{$uploadedFile->extension()}";
            $result = $this->initClient()->putObject([
                'Bucket' => config('filesystems.disks.s3.bucket'),
                'Key' => $key,
                'SourceFile' => $filePath,
                'ContentType' => $contentType ?: $uploadedFile->getMimeType()
            ]);

            if(! empty($result)
                && !empty($result['@metadata']['statusCode'])
                && $result['@metadata']['statusCode'] == 200
            ){
                return true;
            }

            return false;
        }
    }

    public function download()
    {
        // TODO
    }

    public function generateUrl()
    {
        // TODO
    }
}