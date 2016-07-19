<?php

namespace Wooter\Commands;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Intervention\Image\Facades\Image;
use Wooter\Storage\BackBlazeApi;

class UploadContentToCacheflyCommand extends Command implements SelfHandling
{
    private $srcDirectory;
    /**
     * @var
     */
    private $organizationId;
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $file;

    /**
     * @var
     */
    private $uploadThumb;
    /**
     * @var
     */
    private $thumbFile;
    /**
     * @var
     */
    private $uploadPhoto;

    /**
     * Create a new command instance.
     *
     * @param      $srcDirectory
     * @param      $file
     * @param null $orgId
     * @param null $leagueId
     * @param bool $uploadThumb
     * @param null $thumbFile
     * @param bool $uploadPhoto
     */
    public function __construct($srcDirectory, $file, $orgId = null, $leagueId = null,  $uploadThumb = false,  $thumbFile = null, $uploadPhoto = false )
    {
        $this->srcDirectory = $srcDirectory;
        $this->file = $file;
        $this->organizationId = $orgId;
        $this->leagueId = $leagueId;
        $this->uploadThumb = $uploadThumb;
        $this->thumbFile = $thumbFile;
        $this->uploadPhoto = $uploadPhoto;
    }

    /**
     * @return array
     */
    public function handle()
    {

        $b2 = new BackBlazeApi;

        $b2->b2_authorize_account(config('backblaze.account_id'), config('backblaze.application_key'));

            $videoFilePath = $this->srcDirectory.$this->file;

            $videoFileSize = $this->getFileSize($videoFilePath, "MB");

            $VideoContentType = mime_content_type($videoFilePath);

            if($this->uploadPhoto) {

                $uploadPath = config('backblaze.image.upload_path');
                $cloudThumbPath = config('backblaze.image.upload_path');
                $fileSrc = config('backblaze.image.image_src');
                $thumbSrc = config('backblaze.image.image_src');

            } else {

                $uploadPath = config('backblaze.video.upload_path');
                $cloudThumbPath = config('backblaze.video.thumbnail_path');
                $fileSrc = config('backblaze.video.video_src');
                $thumbSrc = config('backblaze.video.video_thumb_src');
            }

            if($videoFileSize <= 100) {

                $resp = json_decode($b2->b2_get_upload_url(config('backblaze.bucket_id')));

                $token = $resp->authorizationToken;
                $uploadUrl = $resp->uploadUrl;

                $b2->b2_upload_file($uploadPath.$this->file, $videoFilePath,$uploadUrl, $token, $VideoContentType );



            }else{
            
                $fileSize = filesize($videoFilePath);
                $startLarge = json_decode($b2->b2_start_large_file($uploadPath.$this->file, config('backblaze.bucket_id'), $VideoContentType ));





                $minimum_part_size = 100 * (1000 * 1000);

                $total_bytes_sent = 0;
                $bytes_sent_for_part = 0;
                $bytes_sent_for_part = $minimum_part_size;
                $sha1_of_parts = Array();
                $part_no = 1;
                $file_handle = fopen($videoFilePath, "r");


                while($total_bytes_sent < $fileSize) {

                    $getUploadPart = json_decode($b2->b2_get_upload_part_url($startLarge->fileId));

                    $uploadUrl = $getUploadPart->uploadUrl;
                    $token = $getUploadPart->authorizationToken;
                    // Determine the number of bytes to send based on the minimum part size
                    if (($fileSize - $total_bytes_sent) < $minimum_part_size) {
                        $bytes_sent_for_part = ($fileSize - $total_bytes_sent);
                    }


                    fseek($file_handle, $total_bytes_sent);
                    $data_part = fread($file_handle, $bytes_sent_for_part);

                    array_push($sha1_of_parts, sha1($data_part));
                    fseek($file_handle, $total_bytes_sent);


                    $b2->b2_upload_part($uploadUrl, $bytes_sent_for_part, $part_no, $sha1_of_parts[$part_no - 1], $file_handle, $token);

                    $part_no++;
                    $total_bytes_sent = $bytes_sent_for_part + $total_bytes_sent;
                    

                }
                fclose($file_handle);


                $b2->b2_finish_large_file($startLarge->fileId, $sha1_of_parts);

            }


            if($this->uploadThumb)
            {

                $videoThumbFilePath = $this->srcDirectory.$this->thumbFile;

                $VideoThumbContentType = mime_content_type($videoThumbFilePath);

                $resp = json_decode($b2->b2_get_upload_url(config('backblaze.bucket_id')));

                $token = $resp->authorizationToken;
                $uploadUrl = $resp->uploadUrl;
                /*$token = $resp->authorizationToken;
                $uploadUrl = $resp->uploadUrl;*/


                $b2->b2_upload_file($cloudThumbPath.$this->thumbFile, $videoThumbFilePath,$uploadUrl, $token, $VideoThumbContentType );
            }

            return array("file_path" => $fileSrc.$this->file,
                "thumbnail_path" => $thumbSrc.$this->thumbFile);




    }



  


    private function getFileSize($file, $type)
    {
        switch($type){
            case "KB":
                $filesize = filesize($file) * .0009765625; // bytes to KB
                break;
            case "MB":
                $filesize = (filesize($file) * .0009765625) * .0009765625; // bytes to MB
                break;
            case "GB":
                $filesize = ((filesize($file) * .0009765625) * .0009765625) * .0009765625; // bytes to GB
                break;
        }
        if($filesize <= 0){


            return $filesize = 'unknown file size';}
        else{

            return round($filesize, 2);

        }
    }
}
