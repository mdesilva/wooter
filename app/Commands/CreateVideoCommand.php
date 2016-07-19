<?php

namespace Wooter\Commands;

use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Video as VideoModel;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\VideoTooBigException;
use Wooter\Wooter\Repositories\VideoRepository;
use Wooter\LeagueVideo;

class CreateVideoCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $video;
    /**
     * @var null
     */
    private $description;
    /**
     * @var string
     */
    private $prefix;
    /**
     * @var
     */
    private $folder;
    /**
     * @var
     */
    private $organizationFolder;
    /**
     * $var video file chunk flag
     */
    private $chunk;
    /**
     * @var chunk file identifier
     */
    private $chunkIdentifier;
    /**
     * @var chunk file number
     */
    private $chunkNumber;
    /**
     * @var chunk file name
     */
    private $chunkName;
    /**
     * @var total video file size
     */
    private $totalFileSize;
    /**
     *
     */
    private $totalChunks;

    /**
     * Create a new command instance.
     *
     * @param UploadedFile $video
     * @param string       $prefix
     * @param null         $description
     */
    public function __construct(UploadedFile $video, $prefix = '',
                                $folder = null,
                                $organizationFolder = null,
                                $description = null,
                                $chunk = false,
                                $chunkIdentifier = null,
                                $chunkNumber = null,
                                $chunkName = null,
                                $totalFileSize = null,
                                $totalChunks = null )
    {
        $this->video = $video;
        $this->description = $description;
        $this->prefix = $prefix;
        $this->folder = $folder;
        $this->organizationFolder = $organizationFolder;
        $this->chunk = $chunk;
        $this->chunkIdentifier = $chunkIdentifier;
        $this->chunkNumber = $chunkNumber;
        $this->chunkName = $chunkName;
        $this->totalFileSize = $totalFileSize;
        $this->totalChunks = $totalChunks;
    }

    /**
     * Execute the command.
     *
     * @param VideoRepository $videoRepository
     *
     * @return VideoModel
     * @throws DatabaseException
     * @throws Exception
     * @throws VideoTooBigException
     */
    public function handle(VideoRepository $videoRepository)
    {
     
        if ( ! $this->video->isValid()) {
            throw new Exception('File is not valid');
        }

        if (config('file.video.max_size') * config('file.megabyte') < $this->video->getClientSize()){
            throw new VideoTooBigException('The size of the video is too big, max size allowed: ' . config('file.video.max_size') * config('file.megabyte') . ' MB');
        }

        if($this->chunk)
        {
            //Create temporary chunk file
            $fileName = $this->chunkName.'.part'.$this->chunkNumber;
            $filePath_tmp = base_path(config('file.video.temporary_path')."/".$this->chunkIdentifier);
            //Write chunk file on temporary location
            $this->video->move($filePath_tmp, $fileName);

            $total_files_on_server_size = 0;
            $temp_total = 0;
            //Check if we receive all chunks
            foreach(scandir($filePath_tmp) as $file) {
                $temp_total = $total_files_on_server_size;
                $tempfilesize = filesize($filePath_tmp.'/'.$file);
                $total_files_on_server_size = $temp_total + $tempfilesize;
            }


            $video = new VideoModel;
            if ($total_files_on_server_size >= $this->totalFileSize) {

                $orignal_filePath = base_path(config('file.video.upload_path'));

                if (!is_dir($orignal_filePath)) {
                    mkdir($orignal_filePath, 0777, true);
                }


                // create the final destination file
               if (($fp = fopen($orignal_filePath.$this->chunkName, 'w')) !== false) {


                    for ($i=1; $i<=$this->totalChunks; $i++) {


                        fwrite($fp, file_get_contents($filePath_tmp.'/'.$this->chunkName.'.part'.$i));

                    }
                    fclose($fp);
                }

                // rename the temporary directory (to avoid access from other
                // concurrent chunks uploads) and than delete it
                if (rename($filePath_tmp, $filePath_tmp.'_UNUSED')) {
                    $this->rrmdir($filePath_tmp.'_UNUSED');
                } else {
                    $this->rrmdir($filePath_tmp);
                }

                $file = $orignal_filePath.$this->chunkName;


                if ( ! $videoRepository->create($video)) {
                    throw new DatabaseException('Error creating the Video record');
                }

                $fileExt = pathinfo($file, PATHINFO_EXTENSION);
                $fileName = $this->prefix . $video->id . '.' .$fileExt;

                //Rename the uploaded video file in some organized structure
                rename($file, $orignal_filePath.$fileName);

                $video->file_path = config('file.video.visible_path').$fileName;
                $video->file_name = $fileName;
                $video->mime_type = 'video/mp4';
                $video->extension = $fileExt;
                $video->size = $this->totalFileSize;
                $video->description = $this->description;
                if ( ! $videoRepository->update($video)) {
                    throw new DatabaseException('Error saving the Video record');
                }

                $video->complete = "success";
                return $video;

            }

            $video->complete = "unFinished";
            return $video;


        }else{
            $video = new VideoModel;

            if ( ! $videoRepository->create($video)) {
                throw new DatabaseException('Error creating the Video record');
            }
            // $this->video->getExtension() it will give tmp extension. 2016-03-24

            $fileName = $this->prefix . $video->id . '.' .$this->video->getClientOriginalExtension();
            $video->file_path = config('file.video.visible_path') . $fileName;
            $video->file_name = $this->video->getClientOriginalName();
            $video->mime_type = $this->video->getClientMimeType();
            $video->extension = $this->video->getClientOriginalExtension();
            $video->size = $this->video->getClientSize();
            $video->description = $this->description;
            $this->video->move(config('file.video.upload_path'), $fileName);

            if ( ! $videoRepository->update($video)) {
                throw new DatabaseException('Error saving the Video record');
            }

        }


        return $video;
    }


    public function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        rrmdir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}
