<?php

namespace Wooter\Commands;

use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Video as VideoModel;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\FileSystemException;
use Wooter\Wooter\Exceptions\VideoNotFound;
use Wooter\Wooter\Exceptions\VideoTooBigException;
use Wooter\Wooter\Repositories\VideoRepository;

class UpdateVideoCommand extends Command implements SelfHandling
{
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
    private $videoId;

    /**
     * Create a new command instance.
     *
     * @param              $video_id
     * @param UploadedFile $video
     * @param string       $prefix
     * @param null         $description
     */
    public function __construct($video_id, UploadedFile $video, $prefix = '', $description = null)
    {
        $this->video = $video;
        $this->description = $description;
        $this->prefix = $prefix;
        $this->videoId = $video_id;
    }

    /**
     * Execute the command.
     *
     * @param VideoRepository $videoRepository
     *
     * @return VideoModel
     * @throws DatabaseException
     * @throws Exception
     * @throws FileSystemException
     * @throws VideoNotFound
     * @throws VideoTooBigException
     */
    public function handle(VideoRepository $videoRepository)
    {
        if ( ! $this->video->isValid()) {
            throw new Exception('File is not valid');
        }

        $video = $videoRepository->getById($this->videoId);

        if ( ! $video) {
            throw new VideoNotFound;
        }

        if (file_exists($video->file_path) && ! unlink($video->file_path)) {
            throw new FileSystemException('There was an error when deleting the old video');
        }

        if (config('file.video.max_size') * config('file.megabyte') < $this->video->getClientSize()){
            throw new VideoTooBigException('The size of the video is too big, max size allowed: ' . config('file.video.max_size') * config('file.megabyte') . ' MB');
        }

        $fileName = $this->prefix . $video->id . '.' . $this->video->getExtension();
        $video->file_path = config('file.video.upload_path') . $fileName;
        $video->file_name = $this->video->getClientOriginalName();
        $video->mime_type = $this->video->getClientMimeType();
        $video->extension = $this->video->getExtension();
        $video->size = $this->video->getClientSize();
        $video->description = $this->description;
        $this->video->move(config('file.video.upload_path'), $fileName);

        if ( ! $videoRepository->update($video)) {
            throw new DatabaseException('Error saving the Video record');
        }

        return $video;
    }
}
