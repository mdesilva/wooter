<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\VideoRepository;

class UpdateLeagueVideoCacheflySrcAndThumbnailSrcCommand extends Command implements SelfHandling
{
    private $videoId;
    private $data = array();
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($id, $files )
    {
        $this->videoId = $id;
        $this->data = $files;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(VideoRepository $videoRepository)
    {
        $video = $videoRepository->getById($this->videoId);

        $video->file_path = $this->data["file_path"];
        $video->thumbnail_path = $this->data["thumbnail_path"];

        $videoRepository->update($video);

        return;
    }
}
